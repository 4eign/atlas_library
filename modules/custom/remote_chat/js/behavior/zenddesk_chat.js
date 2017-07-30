(function ($, Drupal, window) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {
      //add this to open the chat form
      //<button onclick="zE.activate({hideOnClose: true});">Contact Us</button>

      /*
      window.zESettings = {
        webWidget: {
          launcher: {
            label: {
              '*': 'Chat with a person now'
            }
          },
          contactForm: {
            subject: true,
            tags: ['hola', 'mundo']
          }
        }
      };*/
      $zopim(function() {
        $zopim.livechat.addTags("test1", "test2");
      });
      zE(function() {
        zE.identify({
          //name: 'luis felipe',
          //email: 'luis@example.com',
          //organization: 'VIP'
        });
      });
      // hide the chat
      if (settings.chat.visible == 0){
        zE(function() {
          zE.hide();
        });
      }
    }
  };
})(jQuery, Drupal, window);
