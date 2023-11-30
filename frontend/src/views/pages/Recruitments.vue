<script setup>
  import { FilterMatchMode } from "primevue/api";
  import { ref, onMounted, onBeforeMount } from "vue";
  import axios from "axios";

  const aux = ref({});

  const products = ref(null);
  const productDialog = ref(false);
  const deleteProductDialog = ref(false);
  const deleteProductsDialog = ref(false);
  const product = ref({});
  const selectedProducts = ref(null);
  const dt = ref(null);
  const filters = ref({});
  const submitted = ref(false);

  onBeforeMount(() => {
    initFilters();
  });
  const id = ref(0);
  const candidatResponse = ref({
    email: "",
    response: "",
  });

  const user = ref({
    name: "",
    surname: "",
    cin: "",
    role: "",
    email: "",
    mobile: "",
    address: "",
    city: "",
    permission: "",
    state: "",
  });
  const users = ref([]);
  axios.defaults.withCredentials = true;
  axios.defaults.baseURL = "http://localhost:8000";
  onMounted(() => {
    axios.get("/api/candidats").then((response) => {
      users.value = response.data.data;
      console.log(users.value);
    });
  });
  const action = ref("");
  const openNew = () => {
    action.value = "Add ";
    user.value = {};
    product.value = {};
    submitted.value = false;
    productDialog.value = true;
  };

  const respondToCandidat = (candidatEmail, response) => {
    axios
      .post("/api/candidats/send-email", candidatResponse.value)
      .then((response) => {
        console.log(response.data.data);
      })
      .catch((error) => {
        console.error("Error in Axios request:", error);
      });
    deleteProductsDialog.value = false;
  };

  const uploadFile = () => {
    const fileUrl = "http://localhost:8000/api/candidats/cv/" + id.value;
    const anchor = document.createElement("a");
    anchor.href = fileUrl;
    anchor.download = "cv.pdf";
    anchor.click();
  };

  const findIndexById = (id) => {
    let index = -1;
    for (let i = 0; i < products.value.length; i++) {
      if (products.value[i].id === id) {
        index = i;
        break;
      }
    }
    return index;
  };

  const initFilters = () => {
    filters.value = {
      global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    };
  };
</script>

<template>
  <div class="grid">
    <div class="col-12">
      <div class="card">
        <Toast />

        <DataTable
          ref="dt"
          :value="users"
          v-model:selection="selectedProducts"
          dataKey="id"
          :paginator="true"
          :rows="4"
          :filters="filters"
          paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
          :rowsPerPageOptions="[5, 10, 25]"
          currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products"
          responsiveLayout="scroll"
        >
          <Column
            field="name"
            header="Name"
            :sortable="true"
            headerStyle="width:14%; min-width:10rem;"
          >
            <template>
              <span class="p-column-title">Name</span>
            </template>
          </Column>
          <Column
            field="surname"
            header="Surname"
            :sortable="true"
            headerStyle="width:14%; min-width:10rem;"
          >
            <template>
              <span class="p-column-title">Surname</span>
            </template>
          </Column>

          <Column
            field="mobile"
            header="Mobile"
            :sortable="true"
            headerStyle="width:14%; min-width:10rem;"
          >
            <template>
              <span class="p-column-title">Mobile</span>
            </template>
          </Column>

          <Column header="CV" headerStyle="width:10%; min-width:10rem;">
            <template #body="slotProps">
              <Button
                label="CV"
                class="p-button-rounded p-button-primary mr-2"
                @click="
                  () => {
                    id = slotProps.data.id;
                    uploadFile();
                  }
                "
              />
            </template>
          </Column>

          <Column headerStyle="min-width:5rem;" header="Action">
            <template #body="slotProps">
              <Button
                label="Accept"
                class="p-button-rounded p-button-success mr-2"
                @click="
                  () => {
                    deleteProductsDialog = true;
                    candidatResponse.email = slotProps.data.email;
                    candidatResponse.response = 'accept';
                  }
                " />
              <Button
                label="Reject"
                class="p-button-rounded p-button-warning mt-2"
                @click="
                  () => {
                    deleteProductsDialog = true;
                    candidatResponse.email = slotProps.data.email;
                    candidatResponse.response = 'refuse';
                  }
                "
            /></template>
          </Column>
        </DataTable>

        <Dialog
          v-model:visible="deleteProductsDialog"
          :style="{ width: '450px' }"
          header="Confirm"
          :modal="true"
        >
          <div class="flex align-items-center justify-content-center">
            <i
              class="pi pi-exclamation-triangle mr-3"
              style="font-size: 2rem"
            />
            <span v-if="product"
              >Are you sure you want to delete the selected products?</span
            >
          </div>
          <template #footer>
            <Button
              label="No"
              icon="pi pi-times"
              class="p-button-text"
              @click="deleteProductsDialog = false"
            />
            <Button
              label="Yes"
              icon="pi pi-check"
              class="p-button-text"
              @click="respondToCandidat"
            />
          </template>
        </Dialog>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
  @import "@/assets/demo/styles/badges.scss";
</style>
