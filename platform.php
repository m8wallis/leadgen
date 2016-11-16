<h2>Platform Page Test</h2>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1370448819645868',
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

<script>
// Only works after `FB.init` is called
function myFacebookLogin() {
  FB.login(function(){}, {scope: 'manage_pages'});
}
</script>
<button onclick="myFacebookLogin()">Login with Facebook</button>
