<?php

namespace App\Repositories;

use App\Interfaces\SettingInterface;
use App\Models\Language;
use App\Models\Setting;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingRepository implements SettingInterface
{
    use ApiReturnFormatTrait, FileUploadTrait, CommonHelperTrait;

    private $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return Setting::all();
    }

    public function getLanguage()
    {
        return Language::all();
    }

    public function getCountry()
    {
        return DB::table('countries')->select('name')->get();
    }

    public function getCurrency()
    {
        return DB::table('currencies')->select('id', 'name', 'symbol', 'code')->get();
    }

    public function getDateFormat()
    {
        return DB::table('date_formats')->select('id', 'format', 'normal_view')->get();
    }

    // General setting start
    public function updateGeneralSetting($request)
    {
        try {
            // Application name start
            if ($request->has('application_name')) {
                $setting = $this->model::where('name', 'application_name')->first();
                if ($setting) {
                    $setting->value = $request->application_name;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'application_name';
                    $setting->value = $request->application_name;
                }
                $setting->save();
            }
            // Application name end

            //country start
            if ($request->has('country')) {
                $setting = $this->model::where('name', 'country')->first();
                if ($setting) {
                    $setting->value = $request->country;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'country';
                    $setting->value = $request->country;
                }
                $setting->save();
            }
            //country end

            //application_details start
            if ($request->has('application_details')) {
                $setting = $this->model::where('name', 'application_details')->first();
                if ($setting) {
                    $setting->value = $request->application_details;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'application_details';
                    $setting->value = $request->application_details;
                }
                $setting->save();
            }
            //application_details end
            //country start
            if ($request->has('country')) {
                $setting = $this->model::where('name', 'country')->first();
                if ($setting) {
                    $setting->value = $request->country;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'country';
                    $setting->value = $request->country;
                }
                $setting->save();
            }
            //country end
            //Footer Text start
            if ($request->has('footer_text')) {
                $setting = $this->model::where('name', 'footer_text')->first();
                if ($setting) {
                    $setting->value = $request->footer_text;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'footer_text';
                    $setting->value = $request->footer_text;
                }
                $setting->save();
            }
            //Footer Text end

            //date_formats start
            if ($request->has('date_formats')) {
                $setting = $this->model::where('name', 'date_formats')->first();
                if ($setting) {
                    $setting->value = $request->date_formats;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'date_formats';
                    $setting->value = $request->date_formats;
                }
                $setting->save();
            }
            //date_formats end
            //currency start
            if ($request->has('currency')) {
                $currency = DB::table('currencies')->where('code', $request->currency)->first();
                $setting = $this->model::where('name', 'currency')->first();
                if ($setting) {
                    $setting->value = $request->currency;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'currency';
                    $setting->value = $request->currency;
                }
                $setting->save();
                $setting_symbol = $this->model::where('name', 'currency_symbol')->first();
                
                if ($setting_symbol) {
                    $setting_symbol->value = $currency->symbol;
                } else {
                    $setting_symbol = new $this->model;
                    $setting_symbol->name = 'currency_symbol';
                    $setting_symbol->value = $currency->symbol;
                }
                $setting_symbol->save();
            }
            //currency end

            //Default language start
            if ($request->has('default_language')) {
                $setting = $this->model::where('name', 'default_language')->first();
                $default_lang = @$setting->value;
                if ($setting) {
                    $setting->value = $request->default_language;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'default_language';
                    $setting->value = $request->default_language;
                }

                if(@$default_lang != $request->default_language){
                    $this->setEnvironmentValue('LANG_LOCAL', $request->default_language);
                }

                $setting->save();


                $language = new \App\Repositories\LanguageRepository(new Language());
                $result = $language->languageChange($setting->value);
                if (!$result->original['result']) {
                    return $this->responseWithError(___('alert.language_terms_updated_failed'));
                }
            }
            //Default language end
            //timezone start
            if ($request->has('timezone')) {
                $setting = $this->model::where('name', 'timezone')->first();
                $default_lang = @$setting->value;
                if ($setting) {
                    $setting->value = $request->timezone;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'timezone';
                    $setting->value = $request->timezone;
                }

                if(@$default_lang != $request->timezone){
                    $this->setEnvironmentValue('TIME_REGION', $request->timezone);
                }
                $setting->save();
               
                if (!$result->original['result']) {
                    return $this->responseWithError(___('alert.language_terms_updated_failed'));
                }
            }
            //timezone end

            // White logo start
            if ($request->has('light_logo') && $request->file('light_logo')->isValid()) {
                $setting = $this->model::where('name', 'light_logo')->first();
                if ($setting) {
                    if ($request->hasFile('light_logo')) {
                        $upload = $this->customUpload($request->light_logo, 'backend/uploads/settings/light_logo');
                        if ($upload['status']) {
                            if (@$setting->value) {
                                $this->delete(@$setting->value);
                            }
                            $setting->value = $upload['data']['original'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                    $setting->save();

                } else {
                    $setting = new $this->model;
                    $setting->name = 'light_logo';
                    if ($request->hasFile('light_logo')) {
                        $upload = $this->customUpload($request->light_logo, 'backend/uploads/settings/light_logo');
                        if ($upload['status']) {
                            $setting->value = $upload['data']['original'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                    $setting->save();
                }
            }
            // White logo end


            // Dark logo start
            if ($request->has('dark_logo') && $request->file('dark_logo')->isValid()) {
                $setting = $this->model::where('name', 'dark_logo')->first();
                if ($setting) {
                    if ($request->hasFile('dark_logo')) {
                        $upload = $this->customUpload($request->dark_logo, 'backend/uploads/settings/dark_logo');
                        if ($upload['status']) {
                            if (@$setting->value) {
                                $this->delete(@$setting->value);
                            }
                            $setting->value = $upload['data']['original'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                    $setting->save();

                } else {
                    $setting = new $this->model;
                    $setting->name = 'dark_logo';
                    if ($request->hasFile('dark_logo')) {
                        $upload = $this->customUpload($request->dark_logo, 'backend/uploads/settings/dark_logo');
                        if ($upload['status']) {
                            $setting->value = $upload['data']['original'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                    $setting->save();
                }
            }
            // Dark logo end


            if ($request->has('become_instructor') && $request->file('become_instructor')->isValid()) {
                $setting = $this->model::where('name', 'become_instructor')->first();
                if ($setting) {
                    if ($request->hasFile('become_instructor')) {
                        $upload = $this->customUpload($request->become_instructor, 'backend/uploads/settings/become_instructor');
                        if ($upload['status']) {
                            if (@$setting->value) {
                                $this->delete(@$setting->value);
                            }
                            $setting->value = $upload['data']['original'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                    $setting->save();

                } else {
                    $setting = new $this->model;
                    $setting->name = 'become_instructor';
                    if ($request->hasFile('become_instructor')) {
                        $upload = $this->customUpload($request->become_instructor, 'backend/uploads/settings/become_instructor');
                        if ($upload['status']) {
                            $setting->value = $upload['data']['original'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                    $setting->save();
                }
            }

            if ($request->has('favicon') && $request->file('favicon')->isValid()) {
                $setting = $this->model::where('name', 'favicon')->first();
                if ($setting) {
                    if ($request->hasFile('favicon')) {
                        $upload = $this->customUpload($request->favicon, 'backend/uploads/settings/favicon');
                        if ($upload['status']) {
                            if (@$setting->value) {
                                $this->delete(@$setting->value);
                            }
                            $setting->value = $upload['data']['original'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                    $setting->save();

                } else {
                    $setting = new $this->model;
                    $setting->name = 'favicon';
                    if ($request->hasFile('favicon')) {
                        $upload = $this->customUpload($request->favicon, 'backend/uploads/settings/favicon');
                        if ($upload['status']) {
                            $setting->value = $upload['data']['original'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                    $setting->save();
                }
            }
            if ($request->has('empty_table') && $request->file('empty_table')->isValid()) {
                $setting = $this->model::where('name', 'empty_table')->first();
                if ($setting) {
                    if ($request->hasFile('empty_table')) {
                        $upload = $this->customUpload($request->empty_table, 'backend/uploads/settings/empty_table');
                        if ($upload['status']) {
                            if (@$setting->value) {
                                $this->delete(@$setting->value);
                            }
                            $setting->value = $upload['data']['original'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                    $setting->save();

                } else {
                    $setting = new $this->model;
                    $setting->name = 'empty_table';
                    if ($request->hasFile('empty_table')) {
                        $upload = $this->customUpload($request->empty_table, 'backend/uploads/settings/empty_table');
                        if ($upload['status']) {
                            $setting->value = $upload['data']['original'];
                        } else {
                            return $this->responseWithError($upload['message'], [], 400);
                        }
                    }
                    $setting->save();
                }
            }

            // email_address start
            if ($request->has('email_address')) {
                $setting = $this->model::where('name', 'email_address')->first();
                if ($setting) {
                    $setting->value = $request->email_address;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'email_address';
                    $setting->value = $request->email_address;
                }
                $setting->save();
            }
            // email_address end

            // phone_number start
            if ($request->has('phone_number')) {
                $setting = $this->model::where('name', 'phone_number')->first();
                if ($setting) {
                    $setting->value = $request->phone_number;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'phone_number';
                    $setting->value = $request->phone_number;
                }
                $setting->save();
            }
            // phone_number end

            // office_address start
            if ($request->has('office_address')) {
                $setting = $this->model::where('name', 'office_address')->first();
                if ($setting) {
                    $setting->value = $request->office_address;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'office_address';
                    $setting->value = $request->office_address;
                }
                $setting->save();
            }
            // office_address end

            //office_hours start
            if ($request->has('office_hours')) {
                $setting = $this->model::where('name', 'office_hours')->first();
                if ($setting) {
                    $setting->value = $request->office_hours;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'office_hours';
                    $setting->value = $request->office_hours;
                }
                $setting->save();
            }
            // office_hours end
            //OPEN_AI_KEY start
            if ($request->has('OPEN_AI_KEY')) {
                $setting = $this->model::where('name', 'OPEN_AI_KEY')->first();
                if ($setting) {
                    $setting->value = $request->OPEN_AI_KEY;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'OPEN_AI_KEY';
                    $setting->value = $request->OPEN_AI_KEY;
                }
                $setting->save();
            }
            // office_hours end

            // application_map start
            if ($request->has('application_map')) {
                $setting = $this->model::where('name', 'application_map')->first();
                if ($setting) {
                    $setting->value = $request->application_map;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'application_map';
                    $setting->value = $request->application_map;
                }
                $setting->save();
            }

            // theme_color start
            if ($request->has('ot_primary')) {
                $setting = $this->model::where('name', 'ot_primary')->first();
                if ($setting) {
                    $setting->value = $request->ot_primary;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'ot_primary';
                    $setting->value = $request->ot_primary;
                }
                $setting->save();
            }

            if ($request->has('ot_primary_rgb')) {
                $setting = $this->model::where('name', 'ot_primary_rgb')->first();
                if ($setting) {
                    $setting->value = $request->ot_primary_rgb;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'ot_primary_rgb';
                    $setting->value = $request->ot_primary_rgb;
                }
                $setting->save();
            }

            if ($request->has('ot_secondary')) {
                $setting = $this->model::where('name', 'ot_secondary')->first();
                if ($setting) {
                    $setting->value = $request->ot_secondary;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'ot_secondary';
                    $setting->value = $request->ot_secondary;
                }
                $setting->save();
            }

            if ($request->has('ot_secondary_rgb')) {
                $setting = $this->model::where('name', 'ot_secondary_rgb')->first();
                if ($setting) {
                    $setting->value = $request->ot_secondary_rgb;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'ot_secondary_rgb';
                    $setting->value = $request->ot_secondary_rgb;
                }
                $setting->save();
            }

            if ($request->has('ot_tertiary')) {
                $setting = $this->model::where('name', 'ot_tertiary')->first();
                if ($setting) {
                    $setting->value = $request->ot_tertiary;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'ot_tertiary';
                    $setting->value = $request->ot_tertiary;
                }
                $setting->save();
            }

            if ($request->has('ot_tertiary_rgb')) {
                $setting = $this->model::where('name', 'ot_tertiary_rgb')->first();
                if ($setting) {
                    $setting->value = $request->ot_tertiary_rgb;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'ot_tertiary_rgb';
                    $setting->value = $request->ot_tertiary_rgb;
                }
                $setting->save();
            }

            if ($request->has('ot_primary_btn')) {
                $setting = $this->model::where('name', 'ot_primary_btn')->first();
                if ($setting) {
                    $setting->value = $request->ot_primary_btn;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'ot_primary_btn';
                    $setting->value = $request->ot_primary_btn;
                }
                $setting->save();
            }

            if ($request->has('payment_gateway')) {
                $setting = $this->model::where('name', 'payment_gateway')->first();
                if ($setting) {
                    $setting->value = $request->payment_gateway;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'payment_gateway';
                    $setting->value = $request->payment_gateway;
                }
                $setting->save();
            }

            if ($request->has('instructor_otp_verification')) {
                $setting = $this->model::where('name', 'instructor_otp_verification')->first();
                if ($setting) {
                    $setting->value = $request->instructor_otp_verification;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'instructor_otp_verification';
                    $setting->value = $request->instructor_otp_verification;
                }
                $setting->save();
            }

            if ($request->has('student_otp_verification')) {
                $setting = $this->model::where('name', 'student_otp_verification')->first();
                if ($setting) {
                    $setting->value = $request->student_otp_verification;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'student_otp_verification';
                    $setting->value = $request->student_otp_verification;
                }
                $setting->save();
            }

            // theme_color end

            // application_map end
            return $this->responseWithSuccess(___('alert.Setting updated successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
    // General setting en
    public function updateSeoSetting($request)
    {
        try {
            // author start
            if ($request->has('author')) {
                $setting = $this->model::where('name', 'author')->first();
                if (@$setting) {
                    $setting->value = $request->author;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'author';
                    $setting->value = $request->author;
                }
                $setting->save();
            }
            // author end

            // meta_keyword secret start
            if ($request->has('meta_keyword')) {
                $setting = $this->model::where('name', 'meta_keyword')->first();
                if (@$setting) {
                    $setting->value = $request->meta_keyword;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'meta_keyword';
                    $setting->value = $request->meta_keyword;
                }
                $setting->save();
            }
            // meta_keyword secret end

            // meta_description start
            if ($request->has('meta_description')) {
                $setting = $this->model::where('name', 'meta_description')->first();
                if ($setting) {
                    $setting->value = $request->meta_description;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'meta_description';
                    $setting->value = $request->meta_description;
                }
                $setting->save();
            }
            // meta_description end
            return $this->responseWithSuccess(___('alert.seo_update_successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }


    public function updateTwilioSetting($request)
    {
        try {
            // twilio sid start
            if ($request->has('twilio_sid')) {
                $twilio_sid = $this->model::where('name', 'twilio_sid')->first();
                if ($twilio_sid) {
                    $twilio_sid->update(['value' => $request->twilio_sid]);
                } else {
                    $this->model::create([
                        'name' => 'twilio_sid',
                        'value' => $request->twilio_sid,
                    ]);
                }
                $this->putEnvConfigration('TWILIO_SID', $request->twilio_sid);
            }
            // twilio sid end

            // twilio token start
            if ($request->has('twilio_token')) {
                $twilio_token = $this->model::where('name', 'twilio_token')->first();
                if ($twilio_token) {
                    $twilio_token->update(['value' => $request->twilio_token]);
                } else {
                    $this->model::create([
                        'name' => 'twilio_token',
                        'value' => $request->twilio_token,
                    ]);
                }
                $this->putEnvConfigration('TWILIO_TOKEN', $request->twilio_token);
            }
            // twilio token end

            // twilio number from start
            if ($request->has('twilio_number_from')) {
                $twilio_number_from = $this->model::where('name', 'twilio_number_from')->first();
                if ($twilio_number_from) {
                    $twilio_number_from->update(['value' => $request->twilio_number_from]);
                } else {
                    $this->model::create([
                        'name' => 'twilio_number_from',
                        'value' => $request->twilio_number_from,
                    ]);
                }
                $this->putEnvConfigration('TWILIO_FROM', $request->twilio_number_from);
            }
            // twilio token end
            return $this->responseWithSuccess(___('alert.Twilio_settings_updated_successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function storageSettingUpdate($request)
    {
        try {
            // Application name start
            if ($request->has('file_system')) {
                $setting = $this->model::where('name', 'file_system')->first();
                if ($setting) {
                    $setting->value = $request->file_system;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'file_system';
                    $setting->value = $request->file_system;
                }
                $setting->save();
                $this->setEnvironmentValue('FILESYSTEM_DISK', $request->file_system);
            }
            // Application name end

            if ($request->has('aws_access_key_id') && $request->file_system == 's3') {
                // aws_access_key start
                if ($request->has('aws_access_key_id')) {
                    $setting = $this->model::where('name', 'aws_access_key_id')->first();
                    if ($setting) {
                        $setting->value = $request->aws_access_key_id;
                    } else {
                        $setting = new $this->model;
                        $setting->name = 'aws_access_key_id';
                        $setting->value = $request->aws_access_key_id;
                    }
                    $setting->save();
                    $this->setEnvironmentValue('AWS_ACCESS_KEY_ID', $request->aws_access_key_id);
                }
                // aws_access_key end

                // aws_secret_key start
                if ($request->has('aws_secret_key')) {
                    $setting = $this->model::where('name', 'aws_secret_key')->first();
                    if ($setting) {
                        $setting->value = $request->aws_secret_key;
                    } else {
                        $setting = new $this->model;
                        $setting->name = 'aws_secret_key';
                        $setting->value = $request->aws_secret_key;
                    }
                    $setting->save();
                    $this->setEnvironmentValue('AWS_SECRET_ACCESS_KEY', $request->aws_secret_key);

                }
                // aws_secret_key end

                // aws_region start
                if ($request->has('aws_region')) {
                    $setting = $this->model::where('name', 'aws_region')->first();
                    if ($setting) {
                        $setting->value = $request->aws_region;
                    } else {
                        $setting = new $this->model;
                        $setting->name = 'aws_region';
                        $setting->value = $request->aws_region;
                    }
                    $setting->save();
                    $this->setEnvironmentValue('AWS_DEFAULT_REGION', $request->aws_region);
                }
                // aws_region end

                // aws_bucket start
                if ($request->has('aws_bucket')) {
                    $setting = $this->model::where('name', 'aws_bucket')->first();
                    if ($setting) {
                        $setting->value = $request->aws_bucket;
                    } else {
                        $setting = new $this->model;
                        $setting->name = 'aws_bucket';
                        $setting->value = $request->aws_bucket;
                    }
                    $setting->save();
                    $this->setEnvironmentValue('AWS_BUCKET', $request->aws_bucket);
                }
                // aws_bucket end

                // aws_endpoint start
                if ($request->has('aws_endpoint')) {
                    $setting = $this->model::where('name', 'aws_endpoint')->first();
                    if ($setting) {
                        $setting->value = $request->aws_endpoint;
                    } else {
                        $setting = new $this->model;
                        $setting->name = 'aws_endpoint';
                        $setting->value = $request->aws_endpoint;
                    }
                    $setting->save();
                    $this->setEnvironmentValue('AWS_ENDPOINT', $request->aws_endpoint);
                }
                // aws_endpoint end
            }
            return $this->responseWithSuccess(___('alert.storage_settings_updated_successfully.')); // return success response

        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
    public function updateMailSetting($request)
    {
        try {
            // Mail drive start
            if ($request->has('mail_drive')) {
                $setting = $this->model::where('name', 'mail_drive')->first();
                if ($setting) {
                    $setting->value = $request->mail_drive;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'mail_drive';
                    $setting->value = $request->mail_drive;
                }
                $setting->save();
            }
            // Mail drive end

            // Mail Host start
            if ($request->has('mail_host')) {
                $setting = $this->model::where('name', 'mail_host')->first();
                if ($setting) {
                    if($setting->value != $request->mail_host){
                        $this->setEnvironmentValue('MAIL_HOST', $request->mail_host);
                    }
                    $setting->value = $request->mail_host;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'mail_host';
                    $setting->value = $request->mail_host;
                }
                $setting->save();
            }
            // Mail Host end

            // Mail Host start
            if ($request->has('mail_port')) {
                $setting = $this->model::where('name', 'mail_port')->first();
                if ($setting) {
                    if($setting->value != $request->mail_port){
                        $this->setEnvironmentValue('MAIL_PORT', $request->mail_port);
                    }
                    $setting->value = $request->mail_port;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'mail_port';
                    $setting->value = $request->mail_port;
                }
                $setting->save();
            }
            // Mail Host end

            // Mail Address start
            if ($request->has('mail_address')) {
                $setting = $this->model::where('name', 'mail_address')->first();
                if ($setting) {
                    if($setting->value != $request->mail_address){
                        $this->setEnvironmentValue('MAIL_FROM_ADDRESS', $request->mail_address);
                    }
                    $setting->value = $request->mail_address;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'mail_address';
                    $setting->value = $request->mail_address;
                }
                $setting->save();
            }
            // Mail Address end

            // Form Name start
            if ($request->has('from_name')) {
                $setting = $this->model::where('name', 'from_name')->first();
                if ($setting) {
                    if($setting->value != $request->from_name){
                        $this->setEnvironmentValue('MAIL_FROM_NAME', $request->from_name);
                    }
                    $setting->value = $request->from_name;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'from_name';
                    $setting->value = $request->from_name;
                }
                $setting->save();
            }
            // Form Name end

            // Mail UserName start
            if ($request->has('mail_username')) {
                $setting = $this->model::where('name', 'mail_username')->first();
                if ($setting) {
                    if($setting->value != $request->mail_username){
                        $this->setEnvironmentValue('MAIL_USERNAME', $request->mail_username);
                    }
                    $setting->value = $request->mail_username;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'mail_username';
                    $setting->value = $request->mail_username;
                }
                $setting->save();
            }
            // Mail UserName end

            // Mail UserName start
            if ($request->has('mail_password') && $request->mail_password != "") {
                $setting = $this->model::where('name', 'mail_password')->first();
                if ($setting) {
                    if($setting->value != $request->mail_password){
                        $this->setEnvironmentValue('MAIL_PASSWORD', $request->mail_password);
                    }
                    $setting->value = Crypt::encrypt($request->mail_password);
                } else {
                    $setting = new $this->model;
                    $setting->name = 'mail_password';
                    $setting->value = Crypt::encrypt($request->mail_password);
                }
                $setting->save();
            }
            // Mail UserName end

            //Encryption start
            if ($request->has('encryption')) {
                $setting = $this->model::where('name', 'encryption')->first();
                if ($setting) {
                    if($setting->value != $request->encryption){
                        $this->setEnvironmentValue('MAIL_ENCRYPTION', $request->encryption);
                    }
                    $setting->value = $request->encryption;
                } else {
                    $setting = new $this->model;
                    $setting->name = 'encryption';
                    $setting->value = $request->encryption;
                }
                $setting->save();
            }
            //Encryption end

            return $this->responseWithSuccess(___('alert.mail_settings_updated_successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

}
