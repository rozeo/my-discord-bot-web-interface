<!DOCTYPE html>
<html>
    <head>
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
            integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
            crossorigin="anonymous"
        >

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="X-CSRF-TOKEN" content="{{ csrf_token() }}">
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{{ route('home') }}">
                ALLLIVE Discord Bot Web Interface - powered by Rozeo#4798
            </a>
        </nav>

        <div class="container">
            <div class="row mt-3">
                <div class="col-md-3">
                    <div class="list-group">
                        <a class="list-group-item" href="{{ route('home') }}">
                            Index
                        </a>
                        <a class="list-group-item" href="{{ route('music.index') }}">
                            曲アップロード
                        </a>
                        <a class="list-group-item" href="{{ route('music.list') }}">
                            曲一覧
                        </a>
                    </div>
                </div>

                <div class="col-md-9">
                    @yield('main')
                </div>
            </div>
        </div>
    </body>

    <script
        src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"
    ></script>

    <script
        src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"
    ></script>

    <script
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"
    ></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    @yield('script', false)
</html>