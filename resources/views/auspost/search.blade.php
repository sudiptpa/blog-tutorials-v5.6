<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Australia Post API</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
        .search{
            margin-top: 100px;
        }

        .search .tt-input{
            border-radius:0 !important
        }
        .search .tt-menu{
            background:#ffffff;
            width:100%;
            padding:0;
            border:1px solid #E1E1E1;
            border-top:0;
            display:block;
            border-radius:0;
            margin:0
        }
        .search, .search .tt-suggestion{
            padding:8px 10px;
            border-top:1px solid #CCCCCC;
            cursor:pointer
        }
        .search:first-child, .search .tt-suggestion:first-child{
            border-top:0
        }
        .search strong, .search .tt-suggestion strong{
            display:block;
            text-align:center;
            font-size:14px;
            padding:8px 10px
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center search">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Australia Post API - Suburbs and Postcodes Search</div>

                <div class="card-body">
                    <form method="POST" action="">
                        @csrf

                        <div class="form-group row">
                            <label for="search" class="col-md-4 col-form-label text-md-right">Postcode</label>
                            <div class="col-md-8">
                                <input id="search" type="text" data-suggest-postcode="{{ route('app.postcode.api.search') }}" class="form-control" name="email">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

<script type="text/javascript">
        ;
        var App = {};

        (function($, App, window, document, undefined) {
            'use strict';

            App.Auspost = {
                engine: function($el, key) {
                    return new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('location'),
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        remote: {
                            url: $el.data('suggest-postcode') + '?query=%QUERY',
                            wildcard: '%QUERY'
                        }
                    });
                },

                setup: function($el, key) {
                    $el.typeahead({ minLength: 3 }, {
                        limit: 20,
                        source: App.Auspost.engine($el, key).ttAdapter(),
                        templates: {
                            notFound: function () {
                                return '<div class="text-danger"><strong>Your search does not match any locations.</strong></div>';
                            },
                            suggestion: function(data) {
                                return [
                                    '<div class="suggestion">',
                                        '<span class="location">' + data.location + '</span>, ',
                                        '<span class="state">' + data.state + '</span>, ',
                                        '<span class="postcode">' + data.postcode + '</span>',
                                    '</div>',
                                ].join('\n');
                            }
                        }
                    }).on('typeahead:selected', function(event, item) {
                        $('[data-suggest-postcode]').typeahead('val', item.postcode);
                    });
                }
            };


            $(function() {
                $('[data-suggest-postcode]').each(function(index) {
                    App.Auspost.setup($(this));
                });
            });

        }(jQuery, App, window, document));
    </script>
</body>
</html>
