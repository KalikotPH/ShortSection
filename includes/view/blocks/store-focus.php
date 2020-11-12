<?php
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) 
	{
		exit;
	}

    /**
	 * @package shortsection-wp-plugin
     * @version 0.1.0
    */
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="listing">
                <form class="row" id="store_search_form" action="#" method="post" style="margin-bottom: 18px !important;">
                    <div class="row form-group input-group" style="display: contents;">
                        <input id="store_search" type="text" class="form-control" placeholder="Search..." aria-label="search" aria-describedby="basic-addon1" style="">
                    </div>
                </form>
                <ul id="listing-cards" class="list-group">
                    <script id="store-listing" type="text/x-handlebars-template"> 
                        {{#each data}}
                        <li class="list-group-item">
                            <strong>{{title}}</strong> - Online Shop >>>
                            <p style="font-style: italic;">{{address}}</p>
                            <!-- <ul>
                                <li style="display:block;">
                                    <span>Phone: </span> +639294294225
                                </li>
                                <li style="display:block;">
                                    <span>Email: </span> bytescrater@gmail.com
                                </li>
                            </ul> -->
                        </li>
                        {{/each}}
                    </script>
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="row" id="featured-cards"></div>
                    <script id="featured-store" type="text/x-handlebars-template"> 
                        {{#each data}}
                            <div class="carousel-item {{class}}">
                                <img src="{{preview}}" class="d-block w-100" alt="...">
                            </div>
                        {{/each}}
                    </script>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready( function ( $ ) 
    {
        $("#store_search_form").submit(function (e) {
            e.preventDefault();
            
            // Get input field values
            var search = $('#store_search').val();

            loadListing({cat: "", search: search });
        });

        loadListing({cat: "" });
        function loadListing(query) {
            $.ajax({
                dataType: 'json',
                type: 'POST', 
                data: query,
                url: '<?= site_url() ?>/wp-json/shortsection/v1/stores/list',
                success : function( data )
                {
                    var regs = document.getElementById('store-listing').innerHTML;
                    var compiled = Handlebars.compile(regs);
                    var genHtml = compiled(data);

                    var carview = document.getElementById('listing-cards');
                    carview.innerHTML = genHtml;
                },
                error : function(jqXHR, textStatus, errorThrown) 
                {
                    console.log("" + JSON.stringify(jqXHR) + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        }

        loadFeatured({ cat: "" }); 
        function loadFeatured(query) {
            var query = {
                cat: "Featured"
            };

            $.ajax({
                dataType: 'json',
                type: 'POST', 
                data: query,
                url: '<?= site_url() ?>/wp-json/shortsection/v1/stores/list',
                success : function( data )
                {
                    var regs = document.getElementById('featured-store').innerHTML;
                    var compiled = Handlebars.compile(regs);
                    var genHtml = compiled(data);

                    var carview = document.getElementById('featured-cards');
                    carview.innerHTML = genHtml;
                },
                error : function(jqXHR, textStatus, errorThrown) 
                {
                    console.log("" + JSON.stringify(jqXHR) + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        }
    });
</script>