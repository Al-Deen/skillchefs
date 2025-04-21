<div class="step-wrapper-contents">
    <div class="step-4">
        <!-- Title -->
        <div class="setp-page-title mb-20">
            <h4 class="title font-600">
                <i class="ri-price-tag-3-line"></i>{{ ___('instructor.Course_SEO') }}
            </h4>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ot-contact-form mb-15">
                    <label class="ot-contact-label">{{ ___('label.Meta Title') }} </label>
                    <input class="ot-contact-input" name="meta_title" id="meta_title"
                        value="{{ @$data['course']->meta_title }}"
                        placeholder="{{ ___('placeholder.Enter meta title') }}">
                </div>
            </div>

            <div class="col-lg-12">
                <div class="ot-contact-form mb-15">
                    <label class="ot-contact-label"> {{ ___('label.Meta Keyword') }} </label>
                    <input class="ot-contact-input" name="meta_keyword" id="meta_keyword"
                        value="{{ @$data['course']->meta_keywords }}"
                        placeholder="{{ ___('placeholder.Enter meta title') }}">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ot-contact-form mb-15">
                    <label class="ot-contact-label"> {{ ___('label.Meta Description') }} </label>
                    <textarea class="form-control" name="meta_description" row="10" cols="5" id="meta_description"
                        placeholder="{{ ___('placeholder.Enter meta description') }}"><?= @$data['course']->meta_description ?></textarea>
                </div>
            </div>

            <div class="col-lg-12">
                <!-- Course Price -->
                <div class="ot-contact-form mb-15">
                    <label class="ot-contact-label">{{ ___('label.Thumbnail') }} </label>
                    <div @if (@$data['course']->metaImage) data-val="{{ showImage(@$data['course']->metaImage->original) }}" @endif
                        data-name="meta_image" class="file @error('meta_image') is-invalid @enderror"
                        data-height="200px "></div>
                    <small
                        class="text-muted">{{ ___('placeholder.NB : Meta image size will 1200px x 627px and not more than 1mb') }}</small>
                </div>
            </div>

        </div>
    </div>
</div>
