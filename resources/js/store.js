import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        page: 0,
        message: {
            snackbar: false,
            description: "",
            color: "",
        },
    },
    mutations: {
        showMessage(state, message) {
            state.message.snackbar = message.snackbar;
            state.message.description = message.description;
            state.message.color = message.color;
        },
        hideMessage(state) {
            state.message.snackbar = false;
        },
    }
})
