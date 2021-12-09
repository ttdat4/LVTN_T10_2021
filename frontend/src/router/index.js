import Vue from 'vue'
import VueRouter from 'vue-router'
//USER 
import User from '../views/Home.vue'
import Home from '../user/Index.vue'
import Login from '../user/Login.vue'
import Cart from '../user/Cart.vue'
import Checkout from '../user/Checkout.vue'
import Product from '../user/Product.vue'
import ProductDetails from '../user/ProductDetails.vue'
import Contact from '../user/Contact.vue'

//ADMIN
//Admin
const Admin = () =>
    import('../views/Admin.vue')
const Productpage = () =>
    import('../admin/product/Productpage.vue')
const AddProduct = () =>
    import('../admin/product/AddProduct.vue')
    const UpdateProduct = () =>
    import('../admin/product/UpdateProduct.vue')
const ListUser = () =>
    import('../admin/ListUser.vue')
const ListSupplier = () =>
    import('../admin/supplier/Supplier.vue')
const Category = () =>
    import('../admin/category/Category.vue')



Vue.use(VueRouter)

const routes = [
    //USER
    {
        path: '/',
        name: 'Home',
        component: User,
        children: [{
                path: '',
                name: 'index',
                component: Home
            },
            {
                path: 'login',
                name: 'Login',
                component: Login
            },
            {
                path: 'cart',
                name: 'Cart',
                component: Cart
            },
            {
                path: 'checkout',
                name: 'Checkout',
                component: Checkout
            },
            {
                path: 'product',
                name: 'Product',
                component: Product
            },
            {
                path: 'productdetails/:url',
                name: 'ProductDetails',
                component: ProductDetails
            },
            {
                path: 'contact',
                name: 'Contact',
                component: Contact
            },
        ]
    },

    //ADMIN
    //Admin
    {
        path: '/admin',
        name: 'Admin',
        component: Admin,
        redirect: '/admin/category',
        children: [{
                path: 'product',
                name: 'Productpage',
                component: Productpage,
            },
            {
                path: 'add-product',
                name: 'AddProduct',
                component: AddProduct,
            },
            {
                path: 'update-product/:url',
                name: 'UpdateProduct',
                component: UpdateProduct,
            },
            {
                path: 'user',
                name: 'User',
                component: ListUser
            },
            {
                path: 'supplier',
                name: 'Supplier',
                component: ListSupplier
            },
            {
                path: 'category',
                name: 'Categoryadmin',
                component: Category,
            },
        ]
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router