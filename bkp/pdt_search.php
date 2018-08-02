
      
           
            <!--<form class="form-inline main-search-form" method="get" action="search-results.php">
               
                <input type="hidden" name="category" id="category" class="form-control input-lg" value="All">
              <div class="input-group" style="width:100%;">
             
                <input id="search" type="text" class="form-control input-lg" name="search" placeholder="Enter keywords of items you want to search" value="<?php echo $search; ?>">
                <div class="input-group-btn">
                  <button class="btn btn-success btn-lg" type="submit" name="search-form" value="true">
                
                  </button>
                </div>
              </div>
            </form>-->
  <form  method="get" action="search-results.php">
         <input type="hidden" name="category" id="category" class="form-control input-lg" value="All">
            <!--<input type="search" name="s" id="s" placeholder="Search global ecommerce sites here...">-->
            <input id="search" type="text" name="search" placeholder="Search global ecommerce sites here..." value="<?php echo $search; ?>">
            <input type="submit" value="Search">
        </form>
              
      
      
   


