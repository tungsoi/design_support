<!DOCTYPE html>
<html>
    <head>
        @include('furns.head')
    </head>
<body>
    @include('furns.menu')

    <div id="fullpage" class="">
        <div class="section" id="section0">
            <video id="myVideo" loop muted data-autoplay>
                <source src="{{ asset('assets/furn/video/intro.mp4') }}" type="video/mp4">
            </video>
        </div>
        <div class="section" id="category-first">

            <div class="container-fluid" style="height: 100%; padding: 0px;">
            <div class="row" style="height: 100%">
                @foreach ($categorie_row_1 as $category)
                <div class="col-lg-6 col-md-12 col-sm-12 category" style="
                    background-image: url({{ asset('uploads/'.$category->avatar) }});
                    background-repeat: no-repeat;
                    background-size: cover;
                ">
                    <div class="category-overlay"></div>
                    <div class="category-text">
                      <h2>{{ $category->name }}</h2>
                      <h4 style="font-weight: 400">Tìm hiểu thêm</h4>
                    </div>
                </div>
                @endforeach
            </div>
            </div>
        </div>
        <div class="section" id="category-second">

            <div class="container-fluid"  style="height: 100%; padding: 0px;">
            <div class="row" style="height: 100%">
                @foreach ($categorie_row_2 as $key => $category)
                    @php
                        $class = "col-lg-4 col-md-6 col-sm-12 category";
                        if ($key == 2) {
                            $class = "col-lg-4 col-md-12 col-sm-12 category";
                        }
                    @endphp
                <div class="{{ $class }}" style="
                    background-image: url({{ asset('uploads/'.$category->avatar) }});
                    background-repeat: no-repeat;
                    background-size: cover;
                ">
                    <div class="category-overlay"></div>
                    <div class="category-text">
                      <h2>{{ $category->name }}</h2>
                      <h4 style="font-weight: 400">Tìm hiểu thêm</h4>
                    </div>
                </div>
                @endforeach
            </div>
            </div>
        </div>
        <div class="section" id="category-second">
            <h2>oke</h2>
        </div>
    </div>


    @include('furns.script')
  </body>
</html>
