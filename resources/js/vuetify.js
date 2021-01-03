import Vue from "vue";
import Vuetify from "vuetify";
import colors from "vuetify/lib/util/colors";

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        themes: {
            light: {
                error: "#FF5252",
                info: "#2196F3",
                success: "#4CAF50",
                warning: "#FFC107",
                accent: colors.shades.black,
                white:"#ffffff",
                black:"#000000",
                heading:"#151515",
                icon:"#2E1F54",
                background:"#f5f7f8",
                main:"#8757df",
                secondary:"#777777",
                paragraph:"#777777",
                paragraph2:"#BFBFBF",
                rateColor:"#EBD511",
                footer:"#D1D1D1"
            },
            dark: {
                primary: colors.blue.lighten3
            },
        }
    }
});
