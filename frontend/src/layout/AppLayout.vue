<script setup>
  import { computed, watch, ref } from "vue";
  import AppTopbar from "./AppTopbar.vue";

  import { useLayout } from "@/layout/composables/layout";

  const { layoutConfig, layoutState, isSidebarActive } = useLayout();

  const outsideClickListener = ref(null);

  watch(isSidebarActive, (newVal) => {
    if (newVal) {
      bindOutsideClickListener();
    } else {
      unbindOutsideClickListener();
    }
  });

  const bindOutsideClickListener = () => {
    if (!outsideClickListener.value) {
      outsideClickListener.value = (event) => {
        if (isOutsideClicked(event)) {
          layoutState.overlayMenuActive.value = false;
          layoutState.staticMenuMobileActive.value = false;
          layoutState.menuHoverActive.value = false;
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
    const sidebarEl = document.querySelector(".layout-sidebar");
    const topbarEl = document.querySelector(".layout-menu-button");

    return !(
      sidebarEl.isSameNode(event.target) ||
      sidebarEl.contains(event.target) ||
      topbarEl.isSameNode(event.target) ||
      topbarEl.contains(event.target)
    );
  };
</script>

<template>
  <div class="grid">
    <div class="col-12 lg:col-12">
      <app-topbar></app-topbar>
      <div class="layout-main-container">
        <div class="layout-main">
          <router-view></router-view>
        </div>
      </div>
      <div class="layout-mask"></div>
    </div>
  </div>
</template>

<style lang="scss" scoped></style>
