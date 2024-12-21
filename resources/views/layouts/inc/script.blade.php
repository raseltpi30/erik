<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="{{asset('frontend')}}/booking/booking.js"></script>
<script src="{{asset('frontend')}}/js/script.js"></script>
<script type="text/javascript" src="{{ asset('backend/plugins/toastr/toastr.min.js') }}"></script>

<script>
    @if(Session::has('message'))
  var type = "{{Session::get('alert-type','bg-info')}}"
  switch (type) {
      case 'info':
          toastr.info("{{ Session::get('message') }}");
          break;
      case 'success':
          toastr.success("{{ Session::get('message') }}");
          break;
      case 'warning':
          toastr.warning("{{ Session::get('message') }}");
          break;
      case 'error':
          toastr.error("{{ Session::get('message') }}");
          break;
  }
  @endif
</script>
<script>
    $(document).ready(function() {
        var currentRoute = @json(url()->current());

        // Add 'active' class to the first nav item
        $('nav ul li a:first').addClass('active');

        // Update active class based on the current route
        $('nav ul li a').each(function() {
            if ($(this).attr('href') === currentRoute) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });

        // Handle click event for any nav item
        $('nav ul li a').on('click', function() {
            // Remove 'active' class from all nav items
            $('nav ul li a').removeClass('active');

            // Add 'active' class to the clicked nav item
            $(this).addClass('active');
        });

        // Handle click event for any nav item
        $('nav ul li a').on('click', function() {
            // Remove 'active' class from all nav items
            $('nav ul li a').removeClass('active');

            // Add 'active' class to the clicked nav item
            $(this).addClass('active');
        });
        // Initially set 'HOME' as active
        $('.menus').click(function(e) {
            e.preventDefault(); // Prevent default link behavior

            // Toggle menu visibility
            $('.menu').show();

            // Toggle the visibility of the menu icon and close button
            $('.menus').hide();
            $('.close-btn').show();
        });

        $('.close-btn').click(function(e) {
            e.preventDefault(); // Prevent default link behavior

            // Hide the menu
            $('.menu').hide();

            // Toggle the visibility of the menu icon and close button
            $('.menus').show();
            $('.close-btn').hide();
        });

    });
</script>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Service",
  "serviceType": "Cleaning Services",
  "provider": {
    "@type": "LocalBusiness",
    "name": "Crystal Clean Sydney",
    "image": "URL_to_logo_image",
    "telephone": "0426 280 899",
    "email": "info@crystalcleansyd.com.au",
    "url": "https://www.crystalcleansyd.com",
    "description": "Professional home and office cleaning services in Sydney. Book online today!",
    "priceRange": "$80+",
    "paymentAccepted": [ "Credit Card" ],
    "areaServed": [
      {
        "@type": "City",
        "name": "Sydney"
      }
    ]
  },
  "areaServed": {
    "@type": "AdministrativeArea",
    "name": "Greater Sydney Area"
  },
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "Cleaning Services",
    "itemListElement": [
      {
        "@type": "Offer",
        "itemOffered": {
          "@type": "Service",
          "name": "General Cleaning",
          "description": "Standard cleaning for residential spaces, starting price",
          "price": "130+",
          "priceCurrency": "AUD"
        }
      },
      {
        "@type": "Offer",
        "itemOffered": {
          "@type": "Service",
          "name": "Deep Cleaning",
          "description": "Thorough cleaning including hard to reach areas, starting price",
          "price": "220+",
          "priceCurrency": "AUD"
        }
      },
      {
        "@type": "Offer",
        "itemOffered": {
          "@type": "Service",
          "name": "End-of-Lease Cleaning",
          "description": "Comprehensive cleaning ideal for move-out inspections, starting price",
          "price": "400+",
          "priceCurrency": "AUD"
        }
      },
      {
        "@type": "Offer",
        "itemOffered": {
          "@type": "Service",
          "name": "Organization by the Hour",
          "description": "Personalized organizing services billed by the hour, starting price",
          "price": "80+",
          "priceCurrency": "AUD"
        }
      }
    ]
  }
}
</script>

