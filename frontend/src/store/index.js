import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    name: "",
    token: "",
    cart: [],
    amount: 0,
  },
  mutations: {
    login(state, name) {
      state.name = name;
    },
    addProductToCart(state, cartItem){
      let index = state.cart.find(item => {
        return (item.id === cartItem.id && item.sizeId == cartItem.sizeId)
      });
     
      if(index != null)
      {
        index.quanlity += cartItem.quanlity;
        return;
        
      }
      state.cart.push(cartItem);
      localStorage.setItem('cart', JSON.stringify(state.cart))
    },
    removeProductCart(state,indexRemove){
      state.cart = state.cart.filter((item,index)=>{
        return index !== indexRemove;
      })
      localStorage.setItem('cart', JSON.stringify(state.cart))
    },
    LoadingVuex(state){
      let cart = localStorage.getItem('cart');
      if (cart != null){
        state.cart = JSON.parse(cart);
      }
    },
    plus(state, i) {
      state.cart.forEach((item, index) => {
        if (index === i) {
          item.quanlity++
          localStorage.setItem('cart', JSON.stringify(state.cart))
        }
      })
    },
    minus(state, i) {
      state.cart.forEach((item, index) => {
        if (index === i) {
          if (item.quanlity > 1) {
            item.quanlity--
            localStorage.setItem('cart', JSON.stringify(state.cart))
          }
        }
      })
    },
  },
  actions: {
    addProductToCart: (context, cartItem) =>{
      context.commit("addProductToCart", cartItem);
    },
    removeProductCart: (context, indexRemove) =>{
      context.commit("removeProductCart", indexRemove);
    },
    render: (context) => {
      context.commit("LoadingVuex");
    },
    plus: (context, i) => {
      context.commit("plus", i)
    },
    minus: (context, i) => {
      context.commit("minus", i)
    },
  },
  modules: {
  },
  getters:{
    total(state){
      let total = 0;
      state.cart.forEach(item =>{
        total += item.price * item.quanlity;
      })
      return total;
    },
    amount(state){
      return state.cart.length;
    }
  }
})
