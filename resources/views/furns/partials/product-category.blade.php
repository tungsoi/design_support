<div class="section pt-100px pb-100px">
    <div class="container">
        <div class="category-slider swiper-container" data-aos="fade-up">
            <div class="category-wrapper swiper-wrapper">
                @if (isset($categories) && $categories->count() > 0)
                @foreach ($categories as $category)
                <div class=" swiper-slide">
                    <a href="shop-left-sidebar.html" class="category-inner ">
                        <div class="category-single-item">
                            <i class="fa {{ $category->icon }}" style="font-size: 60px; color: #474747"></i>
                            <span class="title">{{ $category->name }}</span>
                        </div>
                    </a>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
