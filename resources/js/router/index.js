import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";
import { AUTHENTICATE_SELF } from "../store/types/authentication";

Vue.use(VueRouter);

// const Home = () => import(/* webpackChunkName: 'Home' */'../pages/Home.vue');

import Home from '../pages/Home.vue';

// Artworks
// const Artworks = () => import(/* webpackChunkName: 'Artworks' */'../pages/Artworks/Index.vue');
// const Available = () => import(/* webpackChunkName: 'AvailableArtworks' */'../pages/Artworks/Available.vue');
// const Sold = () => import(/* webpackChunkName: "SoldArtworks" */'../pages/Artworks/Sold.vue');

import Artworks from '../pages/Artworks/Index.vue';
import Available from '../pages/Artworks/Available.vue';
import Sold from '../pages/Artworks/Sold.vue';

// Blogs
// const Blogs = () => import(/* webpackChunkName: 'Blog' */'../pages/Blogs/Index.vue');
// const MainBlogs = () => import(/* webpackChunkName: 'Blogs' */'../pages/Blogs/Main.vue');
// const ShowBlogs = () => import(/* webpackChunkName: 'ShowBlog' */'../pages/Blogs/Id/View.vue');

import Blogs from '../pages/Blogs/Index.vue';
import MainBlogs from '../pages/Blogs/Main.vue';
import ShowBlogs from '../pages/Blogs/Id/View.vue';

// const About = () => import(/* webpackChunkName: 'About' */'../pages/About.vue');
// const NotFound = () => import(/* webpackChunkName: 'NotFound' */'../pages/NotFound');

import About from '../pages/About.vue';
import NotFound from '../pages/NotFound';

// for management system
// const Management = () => import(/* webpackChunkName: 'Management' */'../pages/ManagementSystem/Index.vue');
// const Main = () => import(/* webpackChunkName: 'Main' */'../pages/ManagementSystem/Main.vue');
// const Login = () => import(/* webpackChunkName: 'Login' */'../pages/ManagementSystem/Login.vue');
// const Dashboard = () => import(/* webpackChunkName: 'Dashboard' */'../pages/ManagementSystem/AdminPanel/Index.vue');

import Management from '../pages/ManagementSystem/Index.vue'
import Main from '../pages/ManagementSystem/Main.vue'
import Login from '../pages/ManagementSystem/Login.vue'
import Dashboard from '../pages/ManagementSystem/AdminPanel/Index.vue'

// artworks in the management system
// const ProductsIndex = () => import(/* webpackChunkName: 'ProductsIndex' */'../pages/ManagementSystem/Artworks/Index.vue');
// const AvailableProducts = () => import(/* webpackChunkName: 'AvailableArtworks' */'../pages/ManagementSystem/Artworks/Products/Index.vue');
// const CreateProduct = () => import(/* webpackChunkName: 'CreateProduct' */'../pages/ManagementSystem/Artworks/Products/Create.vue');
// const UpdateProduct = () => import(/* webpackChunkName: 'UpdateProduct' */'../pages/ManagementSystem/Artworks/Products/Update.vue');

import ProductsIndex from '../pages/ManagementSystem/Artworks/Index.vue';
import AvailableProducts from '../pages/ManagementSystem/Artworks/Products/Index.vue';
import CreateProduct from '../pages/ManagementSystem/Artworks/Products/Create.vue';
import UpdateProduct from '../pages/ManagementSystem/Artworks/Products/Update.vue';

// orders & requests in artworks
// const OrdersIndex = () => import(/* webpackChunkName: 'OrdersIndex' */'../pages/ManagementSystem/Artworks/Orders/Index.vue');
// const RequestsIndex = () => import(/* webpackChunkName: 'RequestsIndex' */'../pages/ManagementSystem/Artworks/Requests/Index.vue');

import OrdersIndex from '../pages/ManagementSystem/Artworks/Orders/Index.vue';
import RequestsIndex from '../pages/ManagementSystem/Artworks/Requests/Index.vue';

// blogs in the management system
// const ArticlesIndex = () => import(/* webpackChunkName: 'ArticlesIndex' */'../pages/ManagementSystem/Blogs/Index.vue');
// const PostedArticles = () => import(/* webpackChunkName: 'PostedArticles' */'../pages/ManagementSystem/Blogs/Articles/Index.vue');
// const CreateArticle = () => import(/* webpackChunkName: 'CreateArticle' */'../pages/ManagementSystem/Blogs/Articles/Create.vue');
// const UpdateArticle = () => import(/* webpackChunkName: 'UpdateArticle' */'../pages/ManagementSystem/Blogs/Articles/Update.vue');

import ArticlesIndex from '../pages/ManagementSystem/Blogs/Index.vue';
import PostedArticles from '../pages/ManagementSystem/Blogs/Articles/Index.vue';
import CreateArticle from '../pages/ManagementSystem/Blogs/Articles/Create.vue';
import UpdateArticle from '../pages/ManagementSystem/Blogs/Articles/Update.vue';

// for viewing and editing the contents like contact, the events/exhibits, social media links.
// const ContentsIndex = () => import(/* webpackChunkName: 'ContentsIndex' */'../pages/ManagementSystem/Content/Index.vue');
// const MessagesIndex = () => import(/* webpackChunkName: 'MessagesIndex' */'../pages/ManagementSystem/Message/Index.vue');
// const ReceivedMessages = () => import(/* webpackChunkName: 'ReceivedMessagesIndex' */'../pages/ManagementSystem/Message/Main.vue');
// const ViewMessage = () => import(/* webpackChunkName: 'ViewMessage' */'../pages/ManagementSystem/Message/View.vue');

import ContentsIndex from '../pages/ManagementSystem/Content/Index.vue';
import MessagesIndex from '../pages/ManagementSystem/Message/Index.vue';
import ReceivedMessages from '../pages/ManagementSystem/Message/Main.vue';
import ViewMessage from '../pages/ManagementSystem/Message/View.vue';

// artworks in the website
// const ViewArtwork = () => import(/* webpackChunkName: 'ViewProduct' */'../pages/Artworks/Id/View.vue');

import ViewArtwork from '../pages/Artworks/Id/View.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/artworks',
        component: Artworks,
        children: [
            {
                path: "",
                name: "available",
                component: Available,
            },
            {
                path: ":id/:title",
                name: "artwork-product",
                component: ViewArtwork
            },
            {
                path: "private",
                name: "sold",
                component: Sold
            }
        ]
    },

    {
        path: "/management",
        component: Management,
        children: [
            {
                path: "login",
                name: "login",
                component: Login
            },
            {
                path: "admin",
                name: 'admin',
                component: Main,
                meta: {
                    requiresAuth: true
                },
                children: [
                    {
                        path: 'dashboard',
                        name: 'dashboard',
                        component: Dashboard
                    },
                    {
                        path: "products",
                        component: ProductsIndex,
                        children: [
                            {
                                path: "",
                                name: 'products-index',
                                component: AvailableProducts
                            },
                            {
                                path: "create",
                                name: "products-create",
                                component: CreateProduct
                            },
                            {
                                path: "update/:id",
                                name: "products-update",
                                component: UpdateProduct
                            },
                            {
                                path: "orders",
                                name: "orders-index",
                                component: OrdersIndex,
                            },
                            {
                                path: "requests",
                                name: "requests-index",
                                component: RequestsIndex,
                            }
                        ]
                    },
                    {
                        path: 'articles',
                        component: ArticlesIndex,
                        children: [
                            {
                                path: "",
                                name: "articles-index",
                                component: PostedArticles,
                            },
                            {
                                path: "create",
                                name: "article-create",
                                component: CreateArticle,
                            },
                            {
                                path: "update/:id",
                                name: "article-update",
                                component: UpdateArticle
                            }
                        ]
                    },
                    {
                        path: "contents",
                        name: "contents-index",
                        component: ContentsIndex
                    },
                    {
                        path: "messages",
                        component: MessagesIndex,
                        children: [
                            {
                                path: "",
                                name: "messages-index",
                                component: ReceivedMessages,
                            },
                            {
                                path: ":id/",
                                name: "message-view",
                                component: ViewMessage
                            }
                        ]
                    },
                ]
            }
        ]
    },

    {
        path: "/blogs",
        component: Blogs,
        children: [
            {
                path: "",
                name: "blogs",
                component: MainBlogs,
            },
            {
                path: ":id/:title",
                name: "blog-view",
                component: ShowBlogs
            }
        ]
    },
    {
        path: '/about',
        name: 'about',
        component: About
    },
    {
        path: '*',
        component: NotFound
    }
];

const router =  new VueRouter({
    mode: 'history',
    routes,
});

router.beforeEach(async (to, from, next) => {
    const { isAuthenticated } = store.state.authentication;
    const isProtectedRoute = to.matched.some((record) =>  record.meta.requiresAuth);
    const unProtectedRoutes = [
        'login'
    ];

    if (isProtectedRoute) await store.dispatch(AUTHENTICATE_SELF);
    if (isProtectedRoute && !isAuthenticated) return next({ name: 'login' });
    if (unProtectedRoutes.includes(to.name) && isAuthenticated) {
        return next({ name: 'dashboard' });
    }

    next();
});

export default router;
