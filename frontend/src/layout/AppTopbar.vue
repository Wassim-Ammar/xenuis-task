<script setup>
  import { ref, computed, onMounted, onBeforeUnmount } from "vue";
  import { useLayout } from "@/layout/composables/layout";
  import { useRouter } from "vue-router";
  import axios from "axios";

  const { layoutConfig, onMenuToggle } = useLayout();

  const outsideClickListener = ref(null);
  const topbarMenuActive = ref(false);
  const router = useRouter();

  onMounted(() => {
    bindOutsideClickListener();
  });

  onBeforeUnmount(() => {
    unbindOutsideClickListener();
  });

  const logoUrl = computed(() => {
    return `layout/images/${
      layoutConfig.darkTheme.value ? "logo-white" : "logo-dark"
    }.svg`;
  });

  const onTopBarMenuButton = () => {
    topbarMenuActive.value = !topbarMenuActive.value;
  };
  const onSettingsClick = () => {
    topbarMenuActive.value = false;
    router.push("/documentation");
  };
  const topbarMenuClasses = computed(() => {
    return {
      "layout-topbar-menu-mobile-active": topbarMenuActive.value,
    };
  });

  const bindOutsideClickListener = () => {
    if (!outsideClickListener.value) {
      outsideClickListener.value = (event) => {
        if (isOutsideClicked(event)) {
          topbarMenuActive.value = false;
        }
      };
      document.addEventListener("click", outsideClickListener.value);
    }
  };
  const unbindOutsideClickListener = () => {
    if (outsideClickListener.value) {
      document.removeEventListener("click", outsideClickListener);
      outsideClickListener.value = null;
    }
  };
  const isOutsideClicked = (event) => {
    if (!topbarMenuActive.value) return;

    const sidebarEl = document.querySelector(".layout-topbar-menu");
    const topbarEl = document.querySelector(".layout-topbar-menu-button");

    return !(
      sidebarEl.isSameNode(event.target) ||
      sidebarEl.contains(event.target) ||
      topbarEl.isSameNode(event.target) ||
      topbarEl.contains(event.target)
    );
  };

  function logout() {
    axios
      .post("/logout")
      .then((response) => {
        router.push("/login");
        console.log(response.data);
      })
      .catch((error) => {
        console.error(error);
      });
  }
</script>

<template>
  <div class="layout-topbar">
    <button
      class="p-link layout-topbar-menu-button layout-topbar-button"
      @click="onTopBarMenuButton()"
    >
      <i class="pi pi-ellipsis-v"></i>
    </button>

    <div class="layout-topbar-menu" :class="topbarMenuClasses">
      <Button
        label="Logout"
        class="p-button p-button-danger mt-2"
        @click="
          () => {
            logout();
          }
        "
      />
    </div>
  </div>
</template>

<style lang="scss" scoped></style>
