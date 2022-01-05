import Vue from 'vue'
import VueRouter from 'vue-router'
//USER 
import User from '../views/Home.vue'
import Home from '../user/Index.vue'
import Login from '../user/Login.vue'
import Cart from '../user/Cart.vue'
import Checkout from '../user/Checkout.vue'
import ProductDetails from '../user/ProductDetails.vue'
import ProductCategory from '../user/ProductCategory.vue'
import Profile from '../user/Profile.vue'
import NotFound from '../user/NotFound.vue'
import Contact from '../user/Contact.vue'

//ADMIN
//Admin
const Admin = () =>
    import('../views/Admin.vue')
const LoginAdmin = () =>
    import('../admin/loginAdmin.vue')
const ProductTest = () =>
    import('../admin/product/ProductTest.vue')
const ProductPage = () =>
    import('../admin/product/ProductPage.vue')
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
const InvoicePage = () =>
    import('../admin/invoice/invoicePage.vue')



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
                path: 'notfound',
                name: 'NotFound',
                component: NotFound
            },
            {
                path: 'productdetails/:url',
                name: 'ProductDetails',
                component: ProductDetails
            },
            {
                path: 'productcategory',
                name: 'ProductCategory',
                component: ProductCategory
            },
            {
                path: 'profile',
                name: 'Profile',
                component: Profile
            },
            {
                path: 'contact',
                name: 'Contact',
                component: Contact
            },
        ]
    },
    {
        path: '/loginAdmin',
        name: 'LoginAdmin',
        component: LoginAdmin,
    },
    //ADMIN
    //Admin
    {
        
        path: '/admin',
        name: 'Admin',
        component: Admin,
        redirect: '/admin/category',
        children: [
            {
                path: 'producttest',
                name: 'ProductTest',
                component: ProductTest,
            },
            {
                path: 'product',
                name: 'ProductPage',
                component: ProductPage,
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
            {
                path: 'invoice',
                name: 'invoicePage',
                component: InvoicePage,
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