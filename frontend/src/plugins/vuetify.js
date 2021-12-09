import Vue from 'vue';
import Vuetify from 'vuetify/lib/framework';
import colors from 'vuetify/lib/util/colors'
import '@fortawesome/fontawesome-free/css/all.css' // Ensure you are using css-loader

Vue.use(Vuetify);

export default new Vuetify({

    icons: {
        iconfont: 'md' || 'fa' 
      },
      theme: {
        themes: {
            light: {
                background: colors.grey.lighten2, // Not automatically applied
              },
          dark: {
            background: colors.shades.white, // If not using lighten/darken, use base to return hex
            
          },
          
        },
      },
});
