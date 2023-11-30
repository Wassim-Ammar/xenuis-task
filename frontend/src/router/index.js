import { createRouter, createWebHashHistory } from "vue-router";
import AppLayout from "@/layout/AppLayout.vue";

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
      path: "/",
      name: "login",
      component: () => import("@/views/pages/auth/Login.vue"),
    },
    {
      path: "/offer",
      name: "offer",
      component: () => import("@/views/pages/Offer.vue"),
    },

    {
      path: "/register",
      name: "register",
      component: () => import("@/views/pages/auth/Register.vue"),
    },

    {
      path: "/dashboard",
      component: AppLayout,
      children: [
        {
          path: "/admin",
          name: "admin",
          component: () => import("@/views/pages/Admin.vue"),
        },

        {
          path: "/pages/recruitments",
          name: "recruitments",
          component: () => import("@/views/pages/Recruitments.vue"),
        },
        {
          path: "/candidat",
          name: "candidat",
          component: () => import("@/views/pages/Candidat.vue"),
        },
      ],
    },
  ],
});

export default router;
