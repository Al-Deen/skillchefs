<?php

use App\Models\Language;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

function getPagination($ITEM)
{
    return view('common.pagination', compact('ITEM'));
}

function setting($name)
{
    if (Schema::hasTable('settings')) { // Check if the 'settings' table exists
        if (Cache::has('setting')) {
            $setting = Cache::get('setting');
            if (isset($setting[$name])) {
                return $setting[$name];
            }
        } else {
            $setting = Setting::all();
            $setting = $setting->pluck('value', 'name')->toArray();
            Cache::put('setting', $setting);
            if (isset($setting[$name])) {
                return $setting[$name];
            }
        }
    }

    return null;
}

function findDirectionOfLang()
{
    if (Session::has('rtl') && Session::get('rtl') == true) {
        return 'rtl';
    } else {
        return 'ltr';
    }
}

// for menu active
if (!function_exists('set_menu')) {
    function set_menu(array $path, $active = 'mm-active')
    {
        foreach ($path as $route) {
            if (Route::currentRouteName() == $route) {
                return $active;
            }
        }
        return (request()->is($path)) ? $active : '';
    }
}

// for  submenu list item active
if (!function_exists('menu_active_by_route')) {
    function menu_active_by_route($route)
    {
        return request()->routeIs($route) ? 'mm-show' : 'in-active';
    }
}

function menu_active_by_url($url)
{
    return url()->current() == $url ? 'active' : 'in-active';
}

// for menu active
if (!function_exists('is_active')) {
    function is_active(array $path, $active = 'active')
    {
        foreach ($path as $route) {
            if (Route::currentRouteName() == $route) {
                return $active;
            }
        }
        return (request()->is($path)) ? $active : '';
    }
}

function ___($key = null, $replace = [], $locale = null)
{
    $input = explode('.', $key);
    $file = $input[0];
    $term = $input[1] ?? '';
    $app_local = Session::get('locale');
    $file_path = base_path('lang/' . $app_local . '/' . $file . '.json');
    $term = str_replace('_', ' ', $term);

    if (!is_dir(dirname($file_path))) {
        mkdir(dirname($file_path), 0777, true);
    }
    if (!file_exists($file_path)) {
        $data = [];
        file_put_contents($file_path, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    $jsonString = file_get_contents($file_path);
    $data = json_decode($jsonString, true);

    if (@$data[$term]) {
        return $data[$term];
    } else {
        $data[$term] = $term;
        file_put_contents($file_path, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    return $term;
}

// global thumbnails
if (!function_exists('globalAsset')) {
    function globalAsset($path, $default_image = null)
    {
        if ($path == "") {
            return url('backend/uploads/default-images/user2.jpg');
        } else {
            try {

                if (env('FILESYSTEM_DISK') == "s3" && Storage::disk('s3')->exists($path) && $path != "") {
                    return Storage::disk('s3')->url($path);
                } else if (env('FILESYSTEM_DISK') == "local" && file_exists(@$path)) {
                    return url($path);
                } else {
                    if ($default_image == null) {
                        return url('backend/uploads/default-images/user2.jpg');
                    } else {
                        return url("backend/uploads/default-images/$default_image");
                    }
                }
            } catch (\Exception $c) {
                return url("backend/uploads/default-images/$default_image");
            }
        }
    }
}

if (!function_exists('numberTowords')) {
    function numberTowords($num)
    {

        $ones = array(
            0 => ___("number.ZERO"),
            1 => ___("number.ONE"),
            2 => ___("number.TWO"),
            3 => ___("number.THREE"),
            4 => ___("number.FOUR"),
            5 => ___("number.FIVE"),
            6 => ___("number.SIX"),
            7 => ___("number.SEVEN"),
            8 => ___("number.EIGHT"),
            9 => ___("number.NINE"),
            10 => ___("number.TEN"),
            11 => ___("number.ELEVEN"),
            12 => ___("number.TWELVE"),
            13 => ___("number.THIRTEEN"),
            14 => ___("number.FOURTEEN"),
            15 => ___("number.FIFTEEN"),
            16 => ___("number.SIXTEEN"),
            17 => ___("number.SEVENTEEN"),
            18 => ___("number.EIGHTEEN"),
            19 => ___("number.NINETEEN"),
            "01" => ___("number.ZERO ONE"),
            "02" => ___("number.ZERO TWO"),
            "03" => ___("number.ZERO THREE"),
            "04" => ___("number.ZERO FOUR"),
            "05" => ___("number.ZERO FIVE"),
            "06" => ___("number.ZERO SIX"),
            "07" => ___("number.ZERO SEVEN"),
            "08" => ___("number.ZERO EIGHT"),
            "09" => ___("number.ZERO NINE"),
        );
        $tens = array(
            0 => ___("number.ZERO"),
            1 => ___("number.TEN"),
            2 => ___("number.TWENTY"),
            3 => ___("number.THIRTY"),
            4 => ___("number.FORTY"),
            5 => ___("number.FIFTY"),
            6 => ___("number.SIXTY"),
            7 => ___("number.SEVENTY"),
            8 => ___("number.EIGHTY"),
            9 => ___("number.NINETY"),
        );
        $hundreds = array(
            ___("number.HUNDRED"),
            ___("number.THOUSAND"),
            ___("number.MILLION"),
            ___("number.BILLION"),
            ___("number.TRILLION"),
            ___("number.QUADRILLION"),
        ); /*limit t quadrillion */
        $num = number_format($num, 2, ".", ",");
        $num_arr = explode(".", $num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",", $wholenum));
        krsort($whole_arr, 1);
        $rettxt = "";
        foreach ($whole_arr as $key => $i) {

            while (substr($i, 0, 1) == "0") {
                $i = substr($i, 1, 5);
            }

            if ($i < 20) {
                /* echo "getting:".$i; */
                $rettxt .= @$ones[$i];
            } elseif ($i < 100) {
                if (substr($i, 0, 1) != "0") {
                    $rettxt .= $tens[substr($i, 0, 1)];
                }

                if (substr($i, 1, 1) != "0") {
                    $rettxt .= " " . $ones[substr($i, 1, 1)];
                }
            } else {
                if (substr($i, 0, 1) != "0") {
                    $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                }

                if (substr($i, 1, 1) != "0") {
                    $rettxt .= " " . $tens[substr($i, 1, 1)];
                }

                if (substr($i, 2, 1) != "0") {
                    $rettxt .= " " . $ones[substr($i, 2, 1)];
                }
            }
            if ($key > 0) {
                $rettxt .= " " . $hundreds[$key] . " ";
            }
        }
        if ($decnum > 0) {
            $rettxt .= " and ";
            if (@$decnum < 20) {
                $rettxt .= $ones[$decnum];
            } elseif ($decnum < 100) {
                $rettxt .= $tens[substr($decnum, 0, 1)];
                $rettxt .= " " . $ones[substr($decnum, 1, 1)];
            }
        }
        return $rettxt;
    }
}

// Permission check
if (!function_exists('hasPermission')) {
    function hasPermission($keyword)
    {
        if (in_array($keyword, Auth::user()->permissions ?? []) || Auth::user()->role_id == 1) {
            return true;
        }
        return false;
    }
}

if (!function_exists('statusBackend')) {
    function statusBackend($class, $name)
    {
        echo '<span class="badge-basic-' . $class . '-text">' . $name . '</span>';
    }
}

if (!function_exists('userTheme')) {
    function userTheme()
    {
        $session_theme = Cache::get('user_theme');

        if (isset($session_theme)) {
            return $session_theme;
        } else {
            return 'default-theme';
        }
    }
}

function globalLogo($type = 'light')
{
    if (showImage(setting('favicon'))) {
        return showImage(setting('favicon'));
    } else {
        return url("logo.png");
    }
}

if (!function_exists('leadingZero')) {
    function withLeadingZero($number)
    {

        return $number;
    }
}

if (!function_exists('setEnvironmentValue')) {
    function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $str .= "\n"; // In case the searched variable is in the last line without \n
        $keyPosition = strpos($str, "{$envKey}=");
        $endOfLinePosition = strpos($str, PHP_EOL, $keyPosition);
        $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
        $str = substr($str, 0, -1);

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }
}

if (!function_exists('s3Upload')) {
    function s3Upload($directory, $file)
    {
        $directory = 'public/' . $directory;
        return Storage::disk('s3')->put($directory, $file, 'public');
    }
}

if (!function_exists('s3ObjectCheck')) {
    function s3ObjectCheck($path)
    {
        return Storage::disk('s3')->exists($path);
    }
}

// start breadcrumb
if (!function_exists('breadcrumb')) {
    function breadcrumb($list)
    {

        $html = '<div class="col-sm-12">';
        $html .= '<div class="d-flex align-items-center justify-content-between flex-wrap gap-2">';
        if (@$list['title']) {
            $html .= '<h4 class="bradecrumb-title mb-1">' . @$list['title'] . '</h4>';
            unset($list['title']);
        }

        $html .= '<ol class="breadcrumb">';
        foreach ($list['routes'] as $key => $value) {
            if ($key == '#') {
                $html .= '<li class="breadcrumb-item active">' . $value . '</li>';
            } else {
                $html .= '<li class="breadcrumb-item ">';
                $html .= '<a href="' . $key . '">' . $value . '</a>';
                $html .= '</li>';
            }
        }
        $html .= '</ol>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}
// end breadcrumb

if (!function_exists('getCurrency')) {
    function getCurrency()
    {
        $currency = Cache::get('currency');
        if (@$currency) {
            return $currency;
        } else {
            $currency = setting('currency');
            Cache::put('getCurrency', $currency);
            return $currency;
        }
    }
}

if (!function_exists('getCurrencySymbol')) {
    function getCurrencySymbol()
    {
        $currency = '$';
        if (Cache::has('currency_symbol')) {
            $currency = Cache::get('currency_symbol');
        } else {
            $currency = setting('currency_symbol');
            Cache::put('currency_symbol', $currency);
        }
        return $currency;
    }
}

if (!function_exists('showDate')) {
    function showDate($date)
    {
        try {
            if ($date != null) {

                $date_format =

                cache()->remember('date_format', 60 * 60 * 24, function () {
                    return setting('date_format');
                });
                return Carbon::parse($date)->locale(app()->getLocale())->translatedFormat($date_format);
            } else {
                return 'N/A';
            }
        } catch (\Exception $e) {
            return;
        }
    }
}

if (!function_exists('showDateTime')) {
    function showDateTime($date)
    {
        try {
            if ($date != null) {
                $date_format =

                cache()->remember('date_format', 60 * 60 * 24, function () {
                    return setting('date_format');
                });
                return Carbon::parse($date)->locale(app()->getLocale())->translatedFormat($date_format . ' h:i A');
            } else {
                return 'N/A';
            }
        } catch (\Exception $e) {
            return;
        }
    }
}

if (!function_exists('showTime')) {
    function showTime($date)
    {
        try {
            if ($date !== null) {
                return \Carbon\Carbon::parse($date)
                    ->locale(app()->getLocale())
                    ->format('h:i A');
            } else {
                return 'N/A';
            }
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
}

// image show
if (!function_exists('showImage')) {
    function showImage($path, $default_image = null)
    {
        if ($path == "" && $default_image == null) {
            return url("backend/uploads/default-images/default-1.jpeg");
        } else if ($path == "" && $default_image != null) {
            if (file_exists("backend/uploads/default-images/$default_image")) {
                return url("backend/uploads/default-images/$default_image");
            } else {
                return url($default_image);
            }
        } else {
            try {
                if (env('FILESYSTEM_DISK') == "s3" && Storage::disk('s3')->exists($path) && $path != "") {
                    return Storage::disk('s3')->url($path);
                } else if (env('FILESYSTEM_DISK') == "local" && file_exists('storage/' . @$path)) {
                    return url('storage/' . $path);
                } else {
                    if ($default_image == null) {
                        return url("backend/uploads/default-images/default-1.jpeg");
                    } else {
                        if (file_exists("backend/uploads/default-images/$default_image")) {
                            return url("backend/uploads/default-images/$default_image");
                        } else {
                            return url($default_image);
                        }
                    }
                }
            } catch (\Exception $c) {
                return url("backend/uploads/default-images/$default_image");
            }
        }
    }
}

// file download
if (!function_exists('downloadFile')) {
    function downloadFile($path)
    {
        if (env('FILESYSTEM_DISK') == "s3" && Storage::disk('s3')->exists($path) && $path != "") {
            return Storage::disk('s3')->download($path);
        } else if (env('FILESYSTEM_DISK') == "local" && file_exists('storage/' . @$path)) {
            return Storage::disk('public')->download($path);
        } else {
            return url('backend/uploads/default-images/user2.jpg');
        }
    }
}
// number format
if (!function_exists('numberFormat')) {
    function numberFormat($number)
    {
        if ($number == null) {
            return '0.00';
        } else {
            return number_format($number, 2);
        }
    }
}

// price show
if (!function_exists('showPrice')) {
    function showPrice($price)
    {
        if ($price == null) {
            return '0.00';
        } else {
            return getCurrencySymbol() . numberFormat($price);
        }
    }
}

// course type
if (!function_exists('courseType')) {
    function courseType()
    {
        return DB::table('statuses')->whereIn('id', [12, 13, 14])->get();
    }
}

// course level
if (!function_exists('courseLevel')) {
    function courseLevel()
    {
        return DB::table('statuses')->whereIn('id', [18, 19, 20])->get();
    }
}

if (!function_exists('include_route_files')) {
    function include_route_files($folder)
    {
        try {
            $rdi = new RecursiveDirectoryIterator($folder);
            $it = new RecursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

// course preview type
if (!function_exists('coursePreviewType')) {
    function coursePreviewType()
    {
        return DB::table('statuses')->whereIn('id', [15, 16])->get();
    }
}

// course visibility
if (!function_exists('courseVisibility')) {
    function courseVisibility()
    {
        return DB::table('statuses')->whereIn('id', [21, 22, 23])->get();
    }
}

// assignment type
if (!function_exists('assignmentType')) {
    function assignmentType()
    {
        return DB::table('statuses')->whereIn('id', [21, 22])->get();
    }
}

// where between is date search string
if (!function_exists('start_end_datetime')) {
    function start_end_datetime($start_date, $end_date)
    {
        $date = [$start_date . ' ' . '00:00:00', $end_date . ' ' . '23:59:59'];
        return $date;
    }
}

// date time format
if (!function_exists('local_date_time_format')) {
    function local_date_time_format($date)
    {
        $date = Carbon::parse($date);
        return $date->format('Y-m-d\TH:i:s');
    }
}

// minutes to hours
if (!function_exists('minutes_to_hours')) {
    function minutes_to_hours($seconds)
    {
//        $hours = floor($minutes / 60);
//        $minutes = $minutes % 60;
//        if ($hours == 0) {
//            return $minutes . 'm';
//        }
//        if ($minutes == 0) {
//            return $hours . 'h';
//        }
//        return $hours . 'h ' . $minutes . 'm';

        $totalMinutes = floor($seconds / 60);
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        if ($hours == 0) {
            return $minutes . 'm';
        }
        if ($minutes == 0) {
            return $hours . 'h';
        }
        return $hours . 'h ' . $minutes . 'm';
    }
}

// discount price
if (!function_exists('discount_price')) {
    function discount_price($course)
    {
        $price = 0;
        if ($course->is_discount == 10) {
            return $price;
        }
        if ($course->discount_type == 2) {
            $price = $course->price - (($course->discount_price / 100) * $course->price);
        } else {
            $price = $course->price - $course->discount_price;
        }
        return $price;
    }
}
;
// discount price
if (!function_exists('course_discount_price')) {
    function course_discount_price($course)
    {
        $price = 0;
        if ($course->is_discount == 10) {
            return $price;
        }
        if ($course->discount_type == 2) {
            $price = ($course->discount_price / 100) * $course->price;
        } else {
            $price = $course->discount_price;
        }
        return $price;
    }
}
;

// tax price
if (!function_exists('tax_price')) {
    function tax_price($price)
    {
        return 0;
    }
}
;

// encrypt id
if (!function_exists('encryptFunction')) {
    function encryptFunction($number = null)
    {

        return openssl_encrypt($number, "AES-128-CTR", "CodeSpeedyKeybj54HH", 0, '8565825542115032');
    }
}
;

// decrypt id
if (!function_exists('decryptFunction')) {
    function decryptFunction($encrypted = null)
    {
        return openssl_decrypt($encrypted, "AES-128-CTR", "CodeSpeedyKeybj54HH", 0, '8565825542115032');
    }
}
;

// Use for Student Id
if (!function_exists('student_id')) {
    function student_id()
    {
        return auth()->id();
    }
}
;
// Use for Student Id

// Date picker date format
if (!function_exists('date_picker_format')) {
    function date_picker_format($date)
    {
        return !empty($date) ? date('m/d/Y', strtotime($date)) : '';
    }
}
;

// Date picker date format

// DB date format
if (!function_exists('date_db_format')) {
    function date_db_format($date)
    {
        return !empty($date) ? date('Y-m-d', strtotime($date)) : '';
    }
}
;
// DB date format

// Year of experience for Student And Instructor
if (!function_exists('totalMonths')) {
    function totalMonths($startDate, $endDate)
    {
        $startDate = \Carbon\Carbon::parse($startDate);
        $endDate = \Carbon\Carbon::parse($endDate ?? date('Y-m-d'));
        return $startDate->diffInMonths($endDate);
    }
}
;
if (!function_exists('monthsToYearAndMonth')) {
    function monthsToYearAndMonth($totalMonths)
    {
        $years = floor($totalMonths / 12);
        $months = $totalMonths % 12;
        if ($years > 1 && $months > 1) {
            echo $years . " years " . $months . " months";
        } elseif ($years > 1) {
            echo $years . " years " . $months . " month";
        } else if ($months > 1) {
            echo $years . " year " . $months . " months";
        }

    }
}
;
// Year of experience for Student And Instructor
function shorten_number(float $number): string
{
    static $min_exponent = 0;
    static $max_exponent = 12;

    if ($number < pow(10, $min_exponent)) {
        return number_format($number);
    }

    $exponent = (int) floor(log10($number) / 3) * 3;
    $exponent = max($exponent, $min_exponent);
    $exponent = min($exponent, $max_exponent);

    switch ($exponent) {
        case 12:
            $abbreviation = 'T';
            break;
        case 9:
            $abbreviation = 'B';
            break;
        case 6:
            $abbreviation = 'M';
            break;
        case 3:
            $abbreviation = 'K';
            break;
        default:
            $abbreviation = '';
            break;
    }

    $display_number = $number / pow(10, $exponent);
    $formatted_number = number_format($display_number, 1);

    if (substr($formatted_number, -2) == '.0') {
        $formatted_number = substr($formatted_number, 0, -2);
    }

    return $formatted_number . $abbreviation;

}

// course level
if (!function_exists('footerLink')) {
    function footerLink($id)
    {
        if (Cache::has('Pages')) {
            $pages = Cache::get('Pages');

        } else {
            $pages = Modules\Page\Entities\Page::where('status_id', 1)->select('id', 'slug')->get();
            Cache::put('Pages', $pages);
        }
        $page = $pages->where('id', $id)->first();

        if (@$page) {
            return route('frontend.page.link', [$page->slug]);
        } else {
            return '';
        }
    }
}

// start status ui
if (!function_exists('status_ui')) {
    function status_ui($type, $class, $title)
    {
        echo '<span class="text-14 status-badge status-' . $class . '">' . $title . '</span>';
    }
}
// end status ui

// table_header
if (!function_exists('table_header')) {
    function table_header($class, $list)
    {
        $html = '<tr>';
        foreach ($list as $key => $value) {
            $html .= '<th class="' . $class . '">' . $value . '</th>';
        }
        $html .= '</tr>';
        echo $html;
    }
}

// start partner instructor ui
if (!function_exists('partner_instructor_ui')) {
    function partner_instructor_ui($instructors)
    {
        $html = '';
        foreach ($instructors as $key => $instructor) {
            // if instructor is not last then add comma and begin line will not add comma
            $comma = ($key < (count($instructors) - 1)) ? ', ' : '';
            // first instructor will not add comma
            $html .= '<a href="' . $key . '" class="text-primary" >' . @$instructor->name . '</a> ' . $comma;
        }
        echo $html;
    }
}

// end partner instructor ui

// start course video url preg match
if (!function_exists('course_video_url_preg_match')) {
    function course_video_url_preg_match($url)
    {
        $video_url = '';
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $video_url = $matches[1];
        } else if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url, $matches)) {
            $video_url = $matches[1];
        } else if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $video_url = $matches[1];
        } else if (preg_match('/\/open\?id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $video_url = $matches[1];
        }
        return $video_url;
    }
}

if (!function_exists('video_get_video_extension')) {
    function video_get_video_extension($url)
    {
        $pathinfo = pathinfo($url);
        $extension = @$pathinfo['extension'];
        return $extension;
    }
}

// end course video url preg match

// start rating ui
if (!function_exists('rating_ui')) {
    function rating_ui($rating, $text_size)
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= floor($rating)) {
                $html .= '<i class="ri-star-fill text-' . $text_size . ' text-yellow"></i>';
            } elseif ($i == ceil($rating) && $rating - floor($rating) == 0.5) {
                $html .= '<i class="ri-star-half-fill text-' . $text_size . ' text-yellow"></i>';
            } else {
                $html .= '<i class="ri-star-line text-' . $text_size . ' text-yellow"></i>';
            }

        }
        echo $html;
    }
}

function lightLogo($light = true)
{
    $html = ('<a href="' . url('/') . '"> <img src="' . showImage(setting('light_logo'), 'logo.png') . '" alt="img"></a>');
    echo $html;
}
function darkLogo($light = true)
{
    $html = ('<a href="' . url('/') . '"> <img src="' . showImage(setting('dark_logo'), 'dark-logo.png') . '" alt="img"></a>');
    echo $html;
}

function gallery($slug)
{
    if (Cache::has('galleries')) {
        $galleries = Cache::get('galleries');
    } else {
        $galleries = \Modules\CMS\Entities\ImageGallery::where('status_id', 1)->select('slug', 'image_id')->get();
        Cache::put('galleries', $galleries);
    }
    $gallery = $galleries->where('slug', $slug)->first();
    if (!@$gallery) {
        \Modules\CMS\Entities\ImageGallery::create([
            'title' => $slug,
            'slug' => $slug,
            'status_id' => 1,
        ]);
    } else if (@$gallery && @$gallery->image) {
        return @$gallery->image->original;
    } else {
        return "";
    }

}

function language()
{
    if (Cache::has('languages')) {
        $languages = Cache::get('languages');
    } else {
        $languages = \App\Models\Language::select('id', 'name', 'code', 'icon_class', 'direction')->get();
        Cache::put('languages', $languages);
    }
    return $languages;
}

function queryCheck($id)
{
    return DB::table('bookmarks')
        ->where('course_id', $id)
        ->where('user_id', auth()->id())
        ->exists();
}

function module($name)
{
    $filePath = base_path('modules_statuses.json');
    $statuses = json_decode(file_get_contents($filePath), true);
    if (isset($statuses[$name])) {
        $isModuleEnabled = $statuses[$name];
        if ($isModuleEnabled) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }

}

function moduleUpdate($name, $status)
{
    $filePath = base_path('modules_statuses.json');
    $statuses = json_decode(file_get_contents($filePath), true);
    $statuses[$name] = $status;
    file_put_contents($filePath, json_encode($statuses));
}

function categoryBacktracking($category_id, $tag = '', $selected_id = null)
{
    $options = '';
    $category = \Modules\Course\Entities\CourseCategory::find($category_id);
    if ($category) {
        $selected = (@$selected_id == $category->id) ? 'selected' : '';
        $options .= '<option ' . $selected . '  value="' . $category->id . '">' . $tag . $category->title . '</option>' . PHP_EOL;
        if ($category->children()->active()->count() > 0) {
            foreach ($category->children()->active()->get() as $child) {
                $childOptions = categoryBacktracking($child->id, $tag . ' ➖ ', $selected_id);
                $options .= $childOptions;
            }
        }
    }
    return $options;
}

if (!function_exists('verificationSetup')) {
    function verificationSetup(){
        $verification = "none";
        if(setting('student_otp_verification') === "0"){
            $verification = "none";
        } elseif(setting('student_otp_verification') === "1"){
            $verification = "email";
        } elseif(setting('student_otp_verification') === "2"){
            $verification = "phone";
        } else{
            $verification = "both";
        }
        return $verification;
    }
}



