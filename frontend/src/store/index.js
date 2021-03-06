import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
 
    token: "",
    cart: [],
    amount: 0,
    user: null,
    listInvoice: "",
    listProduct:"",
    filteredList:"",
    role:"",
  },
  mutations: {
    login(state, user) {
      state.user = user;
      localStorage.setItem("user", JSON.stringify(user));
    },
    role(state, role) {
      state.role = role;
      localStorage.setItem("role", JSON.stringify(role));
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
    removeCartBeforeCheckout(state)
    {
      state.cart = '';
      localStorage.setItem('cart', '')
    },
    LoadingVuex(state){
      let cart = localStorage.getItem('cart');
      let user = localStorage.getItem('user');
      let role = localStorage.getItem('role');
     
      if (cart != null){
        state.cart = JSON.parse(cart);
      }
      if(user != null)
      {
        state.user = JSON.parse(user);
      }
      if(role != null)
      {
        state.role = JSON.parse(role);
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
    getInvoice(state,data){
        state.listInvoice = data;
    },
    getProductCategory(state,data){
      state.listProduct = data;
    },
    filteredList(state,data){
      state.filteredList = data;
    },
  },
  actions: {
    login: (context, user) =>{
      context.commit("login", user);
    },
    role:(context,role) =>{
      context.commit("role",role);
    },
    addProductToCart: (context, cartItem) =>{
      context.commit("addProductToCart", cartItem);
    },
    removeProductCart: (context, indexRemove) =>{
      context.commit("removeProductCart", indexRemove);
    },
    render: (context) => {
      context.commit("LoadingVuex");
    },
    removeCartBeforeCheckout: (context) =>{
      context.commit("removeCartBeforeCheckout");
    },
    plus: (context, i) => {
      context.commit("plus", i);
    },
    minus: (context, i) => {
      context.commit("minus", i);
    },
    getInvoice: (context,data)=>
    {
      context.commit("getInvoice",data);
    },
    filteredList:(context,data)=>{
      context.commit("filteredList",data);
    },
    getProductCategory: (context, data) =>{
      context.commit("getProductCategory",data);
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
