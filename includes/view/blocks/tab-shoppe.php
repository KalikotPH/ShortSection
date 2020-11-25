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
        
<div class="listing-shoppe">
    <form class="row" id="shoppe_search_form" action="#" method="post" style="margin-bottom: 18px !important;">
        <div class="row form-group input-group" style="display: contents;">
            <input id="shoppe_search" type="text" class="form-control" placeholder="Shoppe Search..." aria-label="search" aria-describedby="basic-addon1" style="">
        </div>
    </form>
    <div id="shoppe-listing-cards" class="list-group"></div>
    <ul >
        <script id="shoppe-store-listing" type="text/x-handlebars-template"> 
            {{#each data}}
            <li class="list-group-item" style="margin-right: 7px; padding-left: 12px;">
                <a href="{{preview}}" target="_blank">
                    <img src="{{preview}}" 
                        style="float: left; height: 100px; padding-right: 18px;"/>
                </a>
                <strong>{{title}}</strong>
                <p style="font-style: italic; font-size: smaller; margin-bottom: 0px;">{{address}}</p>
                {{#isEmptyUrl url}}
                    <p>No URL Found</p>
                {{else}}
                    <a href="{{url}}" target="_blank">GO TO {{platform}}</a>
                {{/isEmptyUrl}}  
                
                <!-- <span>Visit </span> <a target="_blank" href="{{redirect}}">{{platform}}</a> -->
            </li>
            {{/each}}
        </script>
    </ul>
</div>

<script type="text/javascript">
    jQuery(document).ready( function ( $ ) 
    {
        Handlebars.registerHelper('isEmptyUrl', function(arg1, options) {
            if(arg1 == '') {
                return options.fn(this);
            }
            return options.inverse(this);
        });

        $("#shoppe_search_form").submit(function (e) {
            e.preventDefault();
            
            // Get input field values
            var search = $('#shoppe_search').val();

            shoppeLoadListing({cat: "", search: search });
        });

        shoppeLoadListing({cat: "Shopee" });
        function shoppeLoadListing(query) {
            $.ajax({
                dataType: 'json',
                type: 'POST', 
                data: query,
                url: '<?= site_url() ?>/wp-json/shortsection/v1/stores/list',
                success : function( data )
                {
                    var regs = document.getElementById('shoppe-store-listing').innerHTML;
                    var compiled = Handlebars.compile(regs);
                    var genHtml = compiled(data);

                    var carview = document.getElementById('shoppe-listing-cards');
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