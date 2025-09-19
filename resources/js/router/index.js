
import { createWebHistory, createRouter, useRoute, useRouter } from "vue-router";
import { userAuthStore } from "@/store/auth";



const PublicLayout = () => import("@/components/layouts/Public.vue");
const PrivateLayout = () => import("@/components/layouts/Private.vue");

const Login = () => import("@/components/public/Login.vue");
const Homepage = () => import("@/components/public/Homepage.vue");

const Dashboard = () => import("@/components/private/Dashboard/Index.vue");
const Users = () => import("@/components/private/Users/Index.vue");
const Trainings = () => import("@/components/private/Trainings/Index.vue");
const Testimonials = () => import("@/components/private/Testimonials/Index.vue");
const Jobs = () => import("@/components/private/Jobs/Index.vue");



const RolesAndPermissions = () => import("@/components/private/RolesPermissions/Index.vue");

// const ProjectProfile = () => import("@/components/private/manage-project/projectprofile.vue");
// const ProjectProfileManage = () => import("@/components/private/manage-project/manage.vue");

 const SettingsMaintenance = () => import("@/components/private/Settings/Maintenance.vue");

const routes = [
    {
        path: "/",
        component: PublicLayout,
        meta: {
            middleware: "guest",
        },
        children: [
            {
                name: "home",
                path: "/",
                component: Homepage,
                meta: {
                    title: `TechKa | Homepage`,
                    label: `Homepage`,
                },
            },
            {
                name: "login",
                path: "/login",
                component: Login,
                meta: {
                    title: `TechKa | Login`,
                    label: `Login`,
                },
            },
        ]
    },
    {
        path: "/app",
        component: PrivateLayout,
        meta: {
            middleware: "auth",
        },
        children: [
            {
                name: "dashboard",
                path: "/app/dashboard",
                component: Dashboard,
                meta: {
                    title: `TechKa | Dashboard`,
                    ability: "dashboard",
                },
            },
            {
                name: "roles-and-permissions",
                path: "/app/roles-and-permissions",
                component: RolesAndPermissions,
                meta: {
                    title: `TechKa | Roles & Permissions`,
                    ability: "roles-and-permissions",
                },
            },
            {
                name: "users",
                path: "/app/manage-users",
                component: Users,
                meta: {
                    title: `TechKa | Users`,
                    ability: "manage-users",
                },
            },
            {
                name: "trainings",
                path: "/app/manage-trainings",
                component: Trainings,
                meta: {
                    title: `TechKa | Trainings`,
                    ability: "manage-trainings",
                },
            },
            {
                name: "testimonials",
                path: "/app/manage-testimonials",
                component: Testimonials,
                meta: {
                    title: `TechKa | Testimonials`,
                    ability: "manage-testimonials",
                },
            },
            {
                name: "jobs",
                path: "/app/manage-jobs",
                component: Jobs,
                meta: {
                    title: `TechKa | Jobs`,
                    ability: "manage-jobs",
                },
            },
            // {
            //     name: "project-profile",
            //     path: "/app/project-profile",
            //     component: ProjectProfile,
            //     meta: {
            //         title: `Project Profile`,
            //         ability: "project-profile",
            //     },
            // },
            // {
            //     name: "manage-project-profile",
            //     path: "/app/project-profile/manage",
            //     component: ProjectProfileManage,
            //     meta: {
            //         title: `Project Profile | Manage`,
            //         ability: "project-profile",
            //     },
            // },
             {
                name: "settings-maintenance",
                path: "/app/settings/maintenance",
                component: SettingsMaintenance,
                meta: {
                    title: `Settings | Maintenance`,
                    ability: "settings-maintenance",
                },
            },
            // {
            //     name: "unauthorized",
            //     path: "/app/unauthorized",
            //     component: Unauthorized,
            //     meta: {
            //         title: `401 | Unauthorized`,
            //         ability: "unauthorized",
            //     },
            // },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    watch: {
        $route(to) {
            if (to.currentRoute.meta.reload == true) {
                window.location.reload();
            }
        },
    },
    scrollBehavior() {
        document.getElementById("app").scrollIntoView();
    },
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    if (to.path === '/login') {
        document.body.classList.add('overflow-hidden');
    } else {
        document.body.classList.remove('overflow-hidden');
    }

    if (to.meta.middleware == "guest") {
        if (userAuthStore().authenticated) {
            next({ name: "dashboard" });
        }
        next();
    } else {
        next();
        // next({ name: "login" });
    }
});

export default router;
