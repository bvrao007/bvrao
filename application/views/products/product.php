<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   ?><!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Welcome to CodeIgniter</title>
      <style type="text/css">
         ::selection { background-color: #E13300; color: white; }
         ::-moz-selection { background-color: #E13300; color: white; }
         body {
         background-color: #fff;
         margin: 40px;
         font: 13px/20px normal Helvetica, Arial, sans-serif;
         color: #4F5155;
         }
         a {
         color: #003399;
         background-color: transparent;
         font-weight: normal;
         text-decoration: none;
         }
         a:hover {
         color: #97310e;
         }
         h1 {
         color: #444;
         background-color: transparent;
         border-bottom: 1px solid #D0D0D0;
         font-size: 19px;
         font-weight: normal;
         margin: 0 0 14px 0;
         padding: 14px 15px 10px 15px;
         }
         code {
         font-family: Consolas, Monaco, Courier New, Courier, monospace;
         font-size: 12px;
         background-color: #f9f9f9;
         border: 1px solid #D0D0D0;
         color: #002166;
         display: block;
         margin: 14px 0 14px 0;
         padding: 12px 10px 12px 10px;
         }
         #body {
         margin: 0 15px 0 15px;
         min-height: 96px;
         }
         p {
         margin: 0 0 10px;
         padding:0;
         }
         p.footer {
         text-align: right;
         font-size: 11px;
         border-top: 1px solid #D0D0D0;
         line-height: 32px;
         padding: 0 10px 0 10px;
         margin: 20px 0 0 0;
         }
         #container {
         margin: 10px;
         border: 1px solid #D0D0D0;
         box-shadow: 0 0 8px #D0D0D0;
         }
      </style>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
      <!-- Latest minified bootstrap js -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   </head>
   <body>
      <div id="container">
      <h1>Welcome to CodeIgniter!</h1>
      <div id="container">
      <h1>Check Offers!</h1>
      <table cellspacing="0" width="70%">
         <thread>
            <th>Item</th>
            <th>Units</th>
            <th>Price*unit</th>
            <th>Offer/Final <BR>Price</th>
         </thread>
         <tbody>
            <?php foreach($products as $p){?>
            <tr>
               <td>
                  <div class="row">
                     <div class="col-md-6">
                     	<!--Displaying items-->
                        <div class="form-group" >
                           <p id="item"><?php echo "Item-".$p->item?></p>
                          
                        </div>
                        <!-- Variables relative to this items
                        	***1. qty:-> CSV of units involve in discount offers;
                        	*	 2. unit_price:->CSV of Price involve in discount offers;
                        	*	 3. has_offer :->0->shows no offers invalved with other items purchase
                        	*	 								else-> it has offers with other items purchase;
                        	*	 4. link_item :->0->shows no link offers for this item
                        	*	 								else->It has link offers. if we purchase link item then this get 													discount price;-->
                        <input type="hidden" id="qty<?php echo $p->_id;?>" value="<?php echo $p->units;?>">
                        <input type="hidden" id="unit_price<?php echo $p->_id;?>" value="<?php echo $p->price;?>">
                        <input type="hidden" id="has_offer<?php echo $p->_id;?>" value="<?php 
                           if($p->has_offer==''){
                           	echo "0";
                           }else{
                           	echo "$p->has_offer";
                           }?>">
                        <input type="hidden" id="link_offer<?php echo $p->_id;?>" value="<?php 
                           if($p->link_item==''){
                           	echo "0";
                           }else{
                           	echo "$p->link_item";
                           }?>">
                     </div>
                  </div>
               </td>
               <td>
                  <button onclick="goto_sub(<?php echo $p->_id;?>);">-</button>
                  <input type="text" id="units<?php echo $p->_id;?>" value="0" style="width: 30px;"></input>
                  <button onclick="goto_add(<?php echo $p->_id;?>);">+</button>
               </td>
               <td>
                  <div class="form-group" >
                     <p id="itemprice<?php echo $p->_id;?>">0</p>
                    
                  </div>
               </td>
               <td>
                  <div class="form-group" >
                     <p id="finalprice<?php echo $p->_id;?>">0</p>
                    
                  </div>
               </td>
            </tr>
            <?php }?>
         </tbody>
      </table>
   </body>
   <script>
   	//** Initializing the global qty and global price
      var gqty=0;
      var gprice=0;
      //*** Item Add button 
      function goto_add(id){
      	var unit_ids="units"+id;
      
      	//*** Checking any offeres are linked with this Item
      	var tag_link_offer="link_offer"+id;
      	var link_offer=$('#'+tag_link_offer).val();
      
      	gqty=$('#'+unit_ids).val();
      
      	if(link_offer==0){
      	//**** calculating basic price, no offers available
      	getvalues(id,gqty,unit_ids,1);
      }else{
      	//**** calculating Offer price, no offers available
      	get_linkoffer_data(id,tag_link_offer,1);
      }
      //**** Checking  any items get offers with this Items
      var tag_has_offer="has_offer"+id;
      	var has_offer=$('#'+tag_has_offer).val();
      
      	
      	if(has_offer!=0){
      	//**** Found Items having offers with this item
      	
      	var tag_has_ids="units"+has_offer;
      	gqty=Number($('#'+tag_has_ids).val());
      
      //*** Updating Item price which having offers with this item 
      		get_linkitem_offers(has_offer,unit_ids,id,1,1);
      	}
      }
      ///** Item Substract unit button 
      function goto_sub(id){
      	var unit_ids="units"+id;
      
      	//*** Checking any offeres are linked with this Item
      	var tag_link_offer="link_offer"+id;
      	var link_offer=$('#'+tag_link_offer).val();
      
      	gqty=$('#'+unit_ids).val();
      
			if(gqty<=0){
            return false;
         }
      	if(link_offer==0){
      	//**** calculating basic price, no offers available
      	getvalues(id,gqty,unit_ids,0);
      }else{
      	//**** calculating Offer price, no offers available
      	get_linkoffer_data(id,tag_link_offer,0);
      }
      //**** Checking  any items get offers with this Items
      var tag_has_offer="has_offer"+id;
      	var has_offer=$('#'+tag_has_offer).val();
      
      	
      	if(has_offer!=0){
      	//**** Found Items having offers with this item
      	tag_link_offer="link_offer"+has_offer;
      	unit_ids="units"+has_offer;
      	gqty=Number($('#'+unit_ids).val());
      
      //*** Updating Item price which having offers with this item 
      		get_linkitem_offers(has_offer,unit_ids,id,0,1);
      	}
      }

      function getvalues(id,qty,unit_ids,type){
      	
      	var tag_unit_price="unit_price"+id;
      	var tag_item_price="itemprice"+id;
      	var tag_qty="qty"+id;
      	var tag_final_price="finalprice"+id;
      
      	var qtys=$('#'+tag_qty).val();
      	var uprice=$('#'+tag_unit_price).val();
      
      	const qtyarray=qtys.split(",");
      	const upricearray=uprice.split(",");
      	
      	let size=Number(qtyarray.length);
      	let units=0;
      	if(type==1){
      		
      		units=Number(qty)+Number(qtyarray[0]);
      		gqty=Number(units);
      	}else if(type==0){
      		//size=Number(qtyarray.length);
      		units=Number(qty)-Number(qtyarray[0]);
      		gqty=Number(units);
      	}else{
      		units=Number(qty);
      	}
      	      	
      	if(size>0){
      	for(let i=size-1;i>=0;i--){
      		      		
      		if(gqty>0){
      			gprice=Number(gprice)+calculate(Number(gqty),Number(qtyarray[i]),Number(upricearray[i]));
      		}
      		      		
      	}
      }      
      	unit_price=Number(upricearray[0])*units;
            
      	document.getElementById(''+unit_ids).value=units;
      	document.getElementById(''+tag_item_price).innerHTML=unit_price;
      	document.getElementById(''+tag_final_price).innerHTML=gprice;
      	//** Initializing the global qty and global price
      gqty=0;
      gprice=0;
      	
      	
      }
      //*** Calculating Price with the offers
      function calculate(qty,units,price){
      	      
      	var tprice=0;

      	//* nqty is the net qty with respect to global quantity/ with offer units
      	var nqty=Math.floor(qty/units);
            
         //* tprice is the offer Amount with the units
      	tprice=nqty*Number(price);
      	
         //** reducing global quantity from netquantity*units( hear units are the offer quantity)
      		gqty=gqty-(units*nqty);
      	      	
      	return tprice;
      }
      
      //__Getting offers data
      function get_linkoffer_data(id,tag,type){
      	var link_offer=$('#'+tag).val();
         var tag_link_unit_ids='';
      	const link_item_id=link_offer.split(",");
      	for(let j=0;j<link_item_id.length;j++){
      		
      		tag_link_unit_ids="units"+link_item_id[j];
      		get_linkitem_offers(id,tag_link_unit_ids,link_item_id[j],type,0);
      	}
      
      }
      // Getting link items units,price to the data
      function get_linkitem_offers(id,tag_link_unit_ids,item_id,type,has_offer){
      	
      	var unit_ids="units"+id;
      	
      	
      	var link_item_price=0;
      	var link_units=0;
      	var offer_units=0;
      	var base_units=0;
      	
      		
      		$.ajax({
                   url : "<?php echo base_url(); ?>index.php/products/get_linkitem_offers",
                   data:{item_id : item_id,id:id},
                   method:'POST',
                   dataType:'json',
                   success:function(response) {
                    //link_units:-> other item purchased units this offers validate
                    //link_item_price:->it is the offer price of the selected item
                    //item_units:->It is the minimum units to purchase of the selected item
                    //base_units:->Selected item base units (minimum purchase without offer)
                      
                      link_units=response['link_units'];
                      link_item_price=response['item_price'];
                      item_units=response['item_units'];
                      base_units=response['base_units'];
                      if(has_offer==0){
                      	if(type==1){
                      	gqty=Number(gqty)+Number(base_units);
                      }else{
                      	gqty=Number(gqty)-Number(base_units);
                      }
                       
                      }
                      
      	
      	 var fqty=gqty;
          
      	 link_qty=$('#'+tag_link_unit_ids).val();
      	
      	 var link_offer_qty=Math.floor(link_qty/link_units);
      	 var item_offer_qty=Math.floor(gqty/item_units);
      	
      	   var offer_qty=item_offer_qty-link_offer_qty;
        
      	   if(link_offer_qty>0){
      
      	   }
      	   if(offer_qty<0){
      	   		
      	   		offer_qty=offer_qty+link_offer_qty;
      	   	
      	   }else{
      	   	offer_qty=link_offer_qty;		   
      	 
      	   }
      	
      	   gqty=fqty-offer_qty;
      	   gprice=offer_qty*link_item_price;
      	  
      	   	getvalues(id,fqty,unit_ids,2);
      	                    
                 }
               });
      	      
      	
      }

   </script>
</html>
