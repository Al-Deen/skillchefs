@include('frontend.partials.lang-static')
<!-- Footer S t a r t -->
<footer>
    <div class="footer-wrapper footer-bg">
        <div class="footer-area footer-padding">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="footer-caption mb-50">
                            <div class="logo wow fadeInUp" data-wow-delay="0.0s">

                                <!-- Logo -->
                                <div class="logo light-logo">
                                    {{ lightLogo() }}
                                </div>

                                <div class="logo dark-logo">
                                    {{ darkLogo() }}
                                </div>

                                <p class="pera2 wow fadeInUp mt-25" data-wow-delay="0.1s">
                                    <?= @setting('application_details') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    @if ($data['footers'])
                        @foreach ($data['footers'] as $footer)
                            <div class="col-xl-2 col-lg-4 col-md-6 col-sm-8">
                                <div class="footer-caption mb-50">
                                    <h4 class="title text-white wow fadeInUp" data-wow-delay="0.0s">{{ @$footer->name }}</h4>
                                    <ul class="listing">
                                        @if (json_decode(@$footer->links))
                                            @foreach (json_decode(@$footer->links) as $child_link)
                                                @if (@$child_link->status_id)
                                                    <li class="list">
                                                        @if (@$child_link->is_page)
                                                            <a href="{{ footerLink($child_link->page_id) }}" class="wow fadeInUp"
                                                                data-wow-delay="0.1s">
                                                                {{ @$child_link->name }} 
                                                            </a>
                                                        @else
                                                            <a href="{{ @$child_link->link }}" class="wow fadeInUp"
                                                                data-wow-delay="0.1s">
                                                                {{ @$child_link->name }}
                                                            </a>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <!-- footer-bottom area -->
        <div class="footer-bottom-area">
            <div class="container">
                <div class="footer-border">
                    <div class="row">
                        <div class="col-xl-12 ">
                            <div class="footer-copy-right text-center">
                                <p class="pera text-white">{{ setting('footer_text') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End-of Footer -->

<!-- Scroll Up  -->
<div class="progressParent">
    <svg class="backCircle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
