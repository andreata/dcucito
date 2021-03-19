<?php
// Add Iubenda consent solution to contact form 7
function iubenda_script_api() {
?>
<script type="text/javascript" src="https://cdn.iubenda.com/consent_solution/iubenda_cons.js"></script>
<script type="text/javascript">
 _iub.cons.init({
    api_key: "CQ8w6K1cW7ORjZuAvXLQ8eiK5GqyVutE"
 });
</script>
<?php
}

add_action( 'wp_head', 'iubenda_script_api' );


function iubenda_consent_script() {
?>
<script type="text/javascript">

jQuery('form[name="checkout"]').on('submit',function(){
    console.log(event)

    	 _iub.cons.submit({
		    form: {
		      selector: jQuery('form[name="checkout"]'),
		      map: {
		        subject: {
		          full_name: "billing_first_name",
		          email: "billing_email"
		        },
		        preferences: {
		          legal_documents: "privacy_policy",
		          //newsletter: "newsletter",
      			  //dem: "dem"
		        }
		      }
		    },
		    consent: {
		      legal_notices: [
		        {
		          identifier: 'privacy_policy',
		         },
		        {
		          identifier: 'cookie_policy',
		        },
		        {
		          identifier: 'terms',
		        }
		        ],
		      }
		  })
		    .success(function (response) {
	        console.log("success", response);
	      })
	      .error(function (response) {
	        console.log("error", response);
	      });

})



document.addEventListener( 'wpcf7mailsent', function( event ) {
    console.log(event)

    	 _iub.cons.submit({
		    form: {
		      selector: jQuery(event.target).find('form'),
		      map: {
		        subject: {
		          full_name: "your-name",
		          email: "your-email"
		        },
		        preferences: {
		          legal_documents: "acceptance-238",
		          //newsletter: "newsletter",
      			  //dem: "dem"
		        }
		      }
		    },
		    consent: {
		      legal_notices: [
		        {
		          identifier: 'privacy_policy',
		         },
		        {
		          identifier: 'cookie_policy',
		        },
		        {
		          identifier: 'terms',
		        }
		        ],
		      }
		  })
		    .success(function (response) {
	        console.log("success", response);
	      })
	      .error(function (response) {
	        console.log("error", response);
	      });

}, false );
</script>
<?php
}

add_action( 'wp_footer', 'iubenda_consent_script' );