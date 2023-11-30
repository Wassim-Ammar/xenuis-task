<script setup>
  import { FilterMatchMode } from "primevue/api";
  import { ref, onMounted, onBeforeMount } from "vue";
  import axios from "axios";

  import { useToast } from "primevue/usetoast";
  const isAdmin = defineProps(["isAdmin"]);
  const toast = useToast();
  const action = ref("");
  const showSuccess = () => {
    toast.add({
      severity: "success",
      summary: "success",
      detail: "Action succeded",
      life: 3000,
    });
  };
  const role = ref(0);
  const offerDialog = ref(false);
  const confirmRequestVar = ref(false);

  const offers = ref({});

  onMounted(() => {
    axios.get("/api/offers").then((response) => {
      offers.value = response.data.data;
    });
  });

  const display = ref(false);
  const description = ref("");
  const open = (description_text) => {
    description.value = description_text;
    display.value = true;
  };

  const offer = ref({
    id: "",
    title: "",
    description: "",
  });
  const close = () => {
    offer.value = {};
    display.value = false;
  };
  const editOffer = () => {
    action.value = "edit";
    offerDialog.value = true;
  };

  const confirmDeleteOffer = () => {
    action.value = "delete";
    confirmRequestVar.value = true;
  };

  const confirmApplyOffer = () => {
    action.value = "apply";
    confirmRequestVar.value = true;
  };

  const openNew = () => {
    offer.value = {};
    action.value = "add";
    offerDialog.value = true;
  };
  const modifyofferRequest = () => {
    axios.get("/sanctum/csrf-cookie").then((response) => {
      if (action.value == "delete") {
        axios
          .delete("/api/offers/" + offer.value.id, offer.value)
          .then((response) => {
            offers.value = response.data.data;
            console.log(response.data.data);
          })
          .catch((error) => {
            console.error("Error in Axios request:", error);
          });
      } else if (action.value == "add") {
        axios
          .post("/api/offers/", offer.value)
          .then((response) => {
            offers.value = response.data.data;
            console.log(response.data.data);
          })
          .catch((error) => {
            console.error("Error in Axios request:", error);
          });
      } else if (action.value == "edit") {
        axios
          .put("/api/offers/" + offer.value.id, offer.value)
          .then((response) => {
            offers.value = response.data.data;
            console.log(response.data.data);
          })
          .catch((error) => {
            console.error("Error in Axios request:", error);
          });
      } else if (action.value == "apply") {
        axios
          .post("/api/candidats/apply/" + offer.value.id)
          .then((response) => {
            showSuccess();
            offers.value = response.data.data;
            console.log(response.data.data);
          })
          .catch((error) => {
            console.error("Error in Axios request:", error);
          });
      }
    });
  };
</script>

<template>
  <Toast />
  <div class="col-12 xl:col-12">
    <div class="card flex flex-column">
      <div class="flex justify-content-between align-items-center mb-5">
        <h5>Offers</h5>
        <div>
          <Button
            v-if="isAdmin.isAdmin == 1"
            label="New"
            icon="pi pi-plus"
            class="p-button-success mr-2"
            @click="openNew"
          />
          <Menu ref="menu2" :popup="true" :model="items"></Menu>
        </div>
      </div>

      <ul
        class="list-none p-0 m-0"
        v-for="(item, index) in offers"
        :key="index"
      >
        <li
          class="flex flex-column md:flex-row md:align-items-center md:justify-content-between mb-4"
        >
          <div>
            <span class="text-900 font-medium mr-2 mb-1 md:mb-0">{{
              item.title
            }}</span>
            <div class="mt-1 text-600 max-width:50%">
              {{ item.created_at }}
            </div>
          </div>

          <span
            class="text-orange-500 ml-3 font-medium"
            v-if="isAdmin.isAdmin == 1"
          >
            <Button
              icon="pi pi-eye"
              class="p-button p-button-primary mr-2"
              @click="
                () => {
                  offer = item;
                  open();
                }
              "
            />
            <Button
              icon="pi pi-pencil"
              class="p-button p-button-warning mr-2"
              @click="
                () => {
                  offer = item;
                  editOffer();
                }
              "
            />
            <Button
              icon="pi pi-trash"
              class="p-button p-button-danger mt-2"
              @click="
                () => {
                  offer = item;
                  confirmDeleteOffer();
                }
              "
            />
          </span>
          <span class="text-orange-500 ml-3 font-medium" v-else>
            <Button
              icon="pi pi-eye"
              class="p-button p-button-primary mr-2"
              @click="
                () => {
                  offer = item;
                  open();
                }
              "
            />
            <Button
              label="apply"
              class="p-button p-button-warning mt-2"
              @click="
                () => {
                  offer = item;
                  confirmApplyOffer();
                }
              "
            />
          </span>
        </li>
      </ul>
    </div>
  </div>

  <Dialog
    :header="offer.title"
    v-model:visible="display"
    :breakpoints="{ '960px': '75vw' }"
    :style="{ width: '30vw' }"
    :modal="true"
  >
    <p class="line-height-3 mb-3">{{ offer.description }}</p>

    <Button
      label="Ok"
      @click="close"
      icon="pi pi-check"
      class="p-button-outlined mt-2"
    />
  </Dialog>
  <Dialog
    v-model:visible="offerDialog"
    :style="{ width: '450px' }"
    header="Offer item "
    :modal="true"
    class="p-fluid"
  >
    <div class="formgrid grid">
      <div class="field col">
        <label for="quantity">Title</label>
        <InputText v-model="offer.title"></InputText>
      </div>
    </div>
    <div class="field">
      <label for="name">Description</label>
      <Textarea v-model="offer.description" />
    </div>
    <template #footer>
      <Button
        label="Cancel"
        icon="pi pi-times"
        class="p-button-text"
        @click="
          () => {
            offerDialog = false;
          }
        "
      />
      <Button
        label="Save"
        icon="pi pi-check"
        class="p-button-text"
        @click="
          () => {
            confirmRequestVar = true;
            offerDialog = false;
          }
        "
      />
    </template>
  </Dialog>
  <Dialog
    v-model:visible="confirmRequestVar"
    :style="{ width: '500px' }"
    header="Confirm"
    :modal="true"
  >
    <div class="flex align-items-center justify-content-center">
      <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
      <span>Are you sure you want to {{ action }} the selected offer ?</span>
    </div>
    <template #footer>
      <Button
        label="No"
        icon="pi pi-times"
        class="p-button-text"
        @click="
          () => {
            confirmRequestVar = false;
          }
        "
      />
      <Button
        label="Yes"
        icon="pi pi-check"
        class="p-button-text"
        @click="
          () => {
            confirmRequestVar = false;
            modifyofferRequest();
          }
        "
      />
    </template>
  </Dialog>
</template>

<style scoped lang="scss">
  @import "@/assets/demo/styles/badges.scss";
</style>
