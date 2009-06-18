<div id="content" class="titulares">
  
  
	<div id="news_headers_main">	 

        <?php echo form_open('usuarios/enviar_titulares'); ?>
     	<fieldset id="news_headers_content">
     	
	<h3>Definir Titulares de LaMula</h3>

	<div id="pie"></div>

    <div id="top_news">

      <div id="top_news_content">          	          	      

        <div id="featured" class="top_news_featured">

          <div class="top_news_content">
          <h3>
              <a href="#">Principal</a>
          </h3>

          <div class="top_news_featured_content">

              <!-- noticia a una columna -->

              <div class="top_news_featured_text">
                  
                  <?php echo form_dropdown('header_1_type', $header_types, $header_1_type); ?>    
                  <br /><?php echo form_input(array('name' => 'header_1_value', 'value' => $header_1_value, 'id' => 'header_1_value')); ?>       
              </div>   

            </div>

            <span class="author"></span>

          </div>

          <div class="top_news_featured_footer">

          </div>

        </div> <!-- top_news_featured -->

  <div id="top_news_list">

    <div class="top_news_item portada-active">
      <h3><a href="#" class="news_item_title"></a></h3>
      <h4> 
        Destacada
      </h4>					
    </div>

    <div class="top_news_item">
      <h3><a href="#" class="news_item_title"></a></h3>
      <h4> 
        <?php echo form_dropdown('header_2_type', $header_types, $header_2_type); ?>    
        <br /><?php echo form_input(array('name' => 'header_2_value', 'value' => $header_2_value, 'id' => 'header_2_value')); ?>       
      </h4>					
    </div>          

    <div class="top_news_item">
      <h3><a href="#" class="news_item_title"></a></h3>
      <h4> 
        <?php echo form_dropdown('header_3_type', $header_types, $header_3_type); ?>    
        <br /><?php echo form_input(array('name' => 'header_3_value', 'value' => $header_3_value, 'id' => 'header_3_value')); ?>       
      </h4>            	
    </div>

    <div class="top_news_item">
      <h3><a href="#" class="news_item_title"></a></h3>
        <?php echo form_dropdown('header_4_type', $header_types, $header_4_type); ?>    
        <br /><?php echo form_input(array('name' => 'header_4_value', 'value' => $header_4_value, 'id' => 'header_4_value')); ?>       
      </h4>
    				
    </div>

    <div class="top_news_item">
      <h3><a href="#" class="news_item_title"></a></h3>
        <?php echo form_dropdown('header_5_type', $header_types, $header_5_type); ?>    		
        <br /><?php echo form_input(array('name' => 'header_5_value', 'value' => $header_5_value, 'id' => 'header_5_value')); ?>       
      </h4>      
    </div>

  </div> <!-- top_news_text -->

  </div> <!-- top_news_content -->


  <div id="top_news_footer">


  </div> <!-- top_news_footer -->  

  </div> <!-- top_news_wrapper -->

    	</fieldset>  
  
  <?php echo form_submit('send_news_headers', 'Actualizar titulares!'); ?>

	  <div />  <!-- text_content -->
	
  
  <?php echo form_close(); ?>
  
</div> <!-- content -->

<div id="sidebar_central">

          <h3>Definir Muleros</h3>
          <?php echo $this->session->flashdata('blogger'); ?>
		<?php echo form_open('usuarios/actualizar_muleros'); ?>
			<h4>Muleros</h4>
			<?php echo form_dropdown('add_bloggers', $bloggers, NULL,'id="add_bloggers"'); ?>
			<?php echo form_submit('update_blogger', 'Agregar'); ?>
			<h4>Muleros actuales</h4>
			<?php echo form_dropdown('remove_bloggers', $defaultsbloggers, NULL,'id="remove_bloggers" multiple="multiple"'); ?>
			<?php echo form_submit('update_blogger', 'Remover'); ?>
		<?php echo form_close(); ?>
		
</div>

<div id="random">
	<?php echo form_open('usuarios/actualizar_random'); ?>
    	<?php echo form_label('Cantidad de bloggers', 'random');?>
    	<?php echo $this->session->flashdata('random') . $this->session->flashdata('value'); ?>
		<?php echo form_input(array('name' => 'random', 'value' => $random, 'id' => 'random')); ?>
		<?php echo form_submit('update_random', 'Actualizar'); ?>
	<?php echo form_close(); ?>
</div>