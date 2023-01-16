<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comments System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
      
<!--   Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<!--  </End icon   -->
      
  </head>
    
  <body>
      
<!--  Main content-->
      
      <div class="container">
				<div class="row justify-content-center">
					<div class="col-md-6">
						<form method="post" id="comment_form">
							<div class="mb-3">
								<label for="name" class="form-label">Name</label>
								<input type="text" class="form-control" id="name" aria-describedby="name" name="name" autocomplete="off" required>
							</div>

							<div class="mb-3">
								<label for="comment" class="form-label">Comment</label>
								<textarea class="form-control" id="comment" name="comment" rows="3" style="height: 100px;" required></textarea>
							</div>

							<input type="hidden" name="parent_id" id="parent_id" value="0" />
							<button type="submit" name="submit" id="submit" class="btn btn-danger btn-kirim mb-5">Submit</button>
						</form>

						<!-- Comment Results -->
						<div class="overflow-auto border border-2 pt-1 ps-1 mb-5" style="max-height: 400px; background-color:whitesmoke;">
							<div id="userComments"></div>
						</div>
						<!-- </End Comment Results -->
					</div>
				</div>
			</div>
      
<!-- </End main content-->
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
      
<!--   Jquery 3.6.3-->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
      
<!--   Jquery script   -->
      <script>
          
      // when the document is ready
      $(document).ready(function(){
          
        // load comments function when the document is ready
        loadComments();
          
         // get the id of the comment form
         $('#comment_form').on('submit', function(e) {
             
                /*  
                e.preventDefault() here means to prevent the data from being sent to the server 
                without refreshing the page using ajax later
                */
             
                e.preventDefault();

                // init ajax
                $.ajax({
                    
                    // set url
                    url: "add_comment.php",
                    
                    // set method
                    method: "POST",
                    
                    // get all form data
                    data: $(this).serialize(),
                    
                    // when successful and the data is successfully entered
                    success: function(response) {
                        
                        // load comments function
                        loadComments();
                        
                        // reset comment form
                        $('#comment_form')[0].reset();
                        
                        // below this if the user does not reply to other user's comments
                        $('#parent_id').val('0');

                    }
                })
            });
          
          // to get the ID of each user and reply to comments
          $(document).on('click', '.reply', function () {
                let id = $(this).attr("id");
                $('#parent_id').val(id);
                $('#name').focus();
          });
          
          
          // load comments function
          function loadComments(){
              
              // init ajax
                $.ajax({
                    
                    // set url
                    url: "display_comments.php",
                    
                    // set method
                    method: "GET",
                    
                    // when the data is successfully retrieved
                    success: function(response) {
                        
                       // display it on the user comment tag div id
                       $('#userComments').html(response);
                    }
                })
            }
      });
      </script>
  </body>
</html>