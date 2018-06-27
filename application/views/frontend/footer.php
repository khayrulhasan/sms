<footer id="main-footer" style="background:url(<?php echo base_url(); ?>public/frontend/images/img-8.jpg) no-repeat 50% 0;">
    <div id="blur-top">
        <a href="#" id="link-back-top">Back to Top</a>
    </div>
    <div id="slogan-footer">
        <h4>Leading Together <span>for</span> Brighter Future</h4>
    </div>
    <div id="footer-content" class="clearfix">
        <div id="footer-container">
            <div id="sidebar-footer-left" class="sidebar-footer">
                <aside class="widget-container">
                    <div class="widget-wrapper clearfix">
                        <h3 class="widget-title">Quick Navigation</h3>
                        <ul>
                            <li><a href="#">Research, Library and Publication</a></li>
                            <li><a href="#">Alumni Center</a></li>
                            <li><a href="#">Academic Community</a></li>
                            <li><a href="#">Extra Curricullum and Student Event</a></li>
                            <li><a href="#">Newsroom, Article and Event</a></li>
                        </ul>
                    </div>
                </aside>
            </div>
            <div id="sidebar-footer-middle" class="sidebar-footer">
                <aside class="widget-container">
                    <div class="widget-wrapper clearfix">
                        <h3 class="widget-title">Campus Location</h3>
                        <article class="text-widget ">
                 <iframe class="map-area" src="http://maps.google.com/?ie=UTF8&amp;ll=37.055177,-95.668945&amp;spn=11.79095,12.150879&amp;t=m&amp;z=6&amp;output=embed"></iframe><br />                                   </article>
                    </div>
                </aside>
            </div>
            <article id="footer-address" class="clearfix">
                <h3 id="title-footer-address"><span>Contact School Fun</span></h3>
                <p><strong>You can contact us via our hotline phone +62 4567 88987 and the Medical Campus is +62 4567 5446</strong></p>
                <p>Vivamus enim massa, egestas quis viverra ut, adipiscing eget metus. Etiam neque orci, cursus vitae sem in, rhoncus vestibulum dolor.</p>
                <ul id="list-social" class="clearfix">
                    <li id="icon-facebook"><a href="#">Facebook</a></li>
                    <li id="icon-twitter"><a href="#">Twitter</a></li>
                    <li id="icon-gplus"><a href="#">Google Plus</a></li>
                    <li id="icon-linkedin"><a href="#">Linkedin</a></li>
                    <li id="icon-youtube"><a href="#">Youtube</a></li>
                    <li id="icon-flickr" class="last"><a href="#">Flickr</a></li>
                </ul>
            </article>
        </div>
    </div>
    <div id="footer-copyright">
        <div id="footer-copyright-content" class="clearfix">
            <a href="#" id="logo-footer"><img src="<?php echo base_url(); ?>public/frontend/images/logo-footer.png" data-retina="images/logo-footer-retina.png" alt="Logo" /></a>
            <p id="text-address">Dhaka, Bangladesh</p>
            <ul id="nav-footer" class="clearfix">
                <li><a href="#">Home</a></li>
                <li><a href="#">Terms</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <p id="text-copyright">Copyright &copy; 2016. All rights reserved</p>
        </div>
    </div>
</footer>


<!-- Script for login modal -->
<script type="text/javascript">
    $(function(){
    var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");
      $('a[data-modal-id]').click(function(e) {
        e.preventDefault();
        $("body").append(appendthis);
        $(".modal-overlay").fadeTo(1000, 0.9);
        //$(".js-modalbox").fadeIn(500);
        var modalBox = $(this).attr('data-modal-id');
        $('#'+modalBox).fadeIn($(this).data());
      });  
    $(".js-modal-close, .modal-overlay").click(function() {
      $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
      });
    });
    $(window).resize(function() {
      $(".modal-box").css({
        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
      });
    });
    $(window).resize();
    });
</script>
<!-- Ajax for Student Login -->
<script type="text/javascript">
  $(document).ready(function(){
      $(document).on( 'submit', 'form.ajax-login-form', function(e){
          $('.loginmodal-submit').val("Loading...");
          $.ajax({
              type: 'post',
              cache: false,
              url: '<?php echo base_url('login/ajax_attempt_login'); ?>',
              data: {
                  'login_string': $('#login_string').val(),
                  'login_pass': $('#login_pass').val(),
                  'login_token': $('[name="token"]').val()
              },
              dataType: 'json',
              success: function(response){
                  $('[name="token"]').val( response.token );
                  //console.log(response);
                  $('.loginmodal-submit').val("Login");
                  if(response.status == 1){
                      $('.loginmodal-submit').val("Success");
                      window.location.replace("<?php echo base_url('frontend/panel/student'); ?>");
                  }else if(response.status == 0 && response.on_hold){
                      $('form').hide();
                      $('#on-hold-message').show();
                      alert('You have exceeded the maximum number of login attempts.');
                  }else if(response.status == 0 && response.count){
                      alert('Failed login attempt ' + response.count + ' of ' + $('#max_allowed_attempts').val());
                  }
              }
          });
          return false;
      });
  });
</script>

</body>
</html>