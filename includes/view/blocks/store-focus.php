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
        <div class="col-lg-4 md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom: 30px;">
                <li class="nav-item">
                    <a class="nav-link active" id="shoppe-tab" data-toggle="tab" href="#shoppe" role="tab" aria-controls="shoppe" aria-selected="true">Shopee</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="lazada-tab" data-toggle="tab" href="#lazada" role="tab" aria-controls="lazada" aria-selected="true">Lazada</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent" style="margin-bottom: 25px;">
                <div class="tab-pane fade show active" id="shoppe" role="tabpanel" aria-labelledby="shoppe-tab">
                    <?php include_once("tab-shoppe.php"); ?>
                </div>
                
                <div class="tab-pane fade" id="lazada" role="tabpanel" aria-labelledby="lazada-tab">
                    <?php include_once("tab-lazada.php"); ?>
                </div>
            </div>
        </div>

        <div class="col-lg-8 md-12">
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
        $('#myTab a').on('click', function (e) {
            e.preventDefault()
        })

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