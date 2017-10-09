<body>
       <div class="row">
           <div class="col-lg-4 col-lg-offset-4" >
           <h3>Nuevo rubro</h3>
       </div>
           <div class="col-lg-3 col-lg-offset-4" >
               <form class="form-signin" action="<?= site_url('Item_controller/load_item'); ?>" method="POST">

                   <h4>Nombre del rubro:</h4>
                     <input type="text" class="form-control" name="name" placeholder="nombre del rubro">
                   <h3></h3>
                   <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Subir</button>
               
               </form>
           </div><!-- /.col-lg-4 -->
       </div>
</body>