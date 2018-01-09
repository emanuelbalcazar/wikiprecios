<body>
       <div class="row">
           <div class="col-lg-4 col-lg-offset-4" >
           <h3>Cargar Producto Especial</h3>
       </div>
           <div class="col-lg-3 col-lg-offset-4" >
               <form class="form-signin" action="<?= site_url('Special_product_controller/load_product'); ?>" method="POST">


                   <h4>Ingrese el nombre:</h4>
                     <input type="text" class="form-control" name="name" placeholder="Nombre del producto especial">
                   <h3></h3>

                   <h4>Seleccione el rubro:</h4>
                   <select class="selectpicker" data-width="100%" name="item" id="item" data-live-search="true">
                       <?php foreach ($items as  $item) { ?>
                           <option value = <?=$item->id;?> title = "<?=$item->name;?>"><?=$item->name;?></option>
                       <?php } ?>
                   </select>
                   <h3></h3>

                   <h4>Seleccione la unidad de medida:</h4>
                   <select class="selectpicker" data-width="100%" name="unit" id="unit" data-live-search="true">
                       <option name = "kg" value = "KG">Kilogramo</option>
                       <option name = "lt" value = "LITRO">Litro</option>
                       <option name = "docena" value = "DOCENA">Docena</option>
                   </select>
                   <h3></h3>

                   <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Cargar</button>
               </form>

           </div><!-- /.col-lg-4 -->
       </div>
   </body>
