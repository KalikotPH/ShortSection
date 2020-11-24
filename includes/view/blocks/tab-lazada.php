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
        
<div class="listing-lazada">
    <form class="row" id="lazada_search_form" action="#" method="post" style="margin-bottom: 18px !important;">
        <div class="row form-group input-group" style="display: contents;">
            <input id="lazada_search" type="text" class="form-control" placeholder="Lazada Search..." aria-label="search" aria-describedby="basic-addon1" style="">
        </div>
    </form>
    <div id="lazada-listing-cards" class="list-group"></div>
    <ul>
        <script id="lazada-store-listing" type="text/x-handlebars-template"> 
            {{#each data}}
            <li class="list-group-item" style="margin-right: 7px; padding-left: 12px;">
                <img src="https://wordpress.dev/wp-content/uploads/2020/11/a40cf4856225ed041378e8fff24b6bfcec226d3f-cache.jpg" 
                    style="float: left; height: 100px; padding-right: 18px;"/>
                <strong>{{title}}</strong>
                <p style="font-style: italic; font-size: smaller;">{{address}}</p>
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

<script type="text/javascript">
    jQuery(document).ready( function ( $ ) 
    {
        $("#lazada_search_form").submit(function (e) {
            e.preventDefault();
            
            // Get input field values
            var search = $('#lazada_search').val();

            lazadaLoadListing({cat: "", search: search });
        });

        lazadaLoadListing({cat: "Lazada" });
        function lazadaLoadListing(query) {
            $.ajax({
                dataType: 'json',
                type: 'POST', 
                data: query,
                url: '<?= site_url() ?>/wp-json/shortsection/v1/stores/list',
                success : function( data )
                {
                    var regs = document.getElementById('lazada-store-listing').innerHTML;
                    var compiled = Handlebars.compile(regs);
                    var genHtml = compiled(data);

                    var carview = document.getElementById('lazada-listing-cards');
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