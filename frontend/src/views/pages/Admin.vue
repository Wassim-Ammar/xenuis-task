<style>
  .flex-right {
    display: flex;
    justify-content: flex-end;
  }
</style>
<script setup>
  import { ref, onMounted } from "vue";
  import TabView from "primevue/tabview";
  import TabPanel from "primevue/tabpanel";
  import Offer from "../pages/Offer.vue";
  import axios from "axios";
  import Recruitments from "../pages/Recruitments.vue";
  const isAdmin = 1;
  const deleteItemsDialog = ref(false);
  const ItemDialog = ref(false);

  const action = ref("");
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
    password: "",
  });

  const password = ref({
    old_password: "",
    new_password: "",
  });

  onMounted(() => {
    axios.get("/sanctum/csrf-cookie").then((response) => {
      axios
        .get("/api/me")
        .then((response) => {
          console.log(response.data.data);
          user.value = response.data.data;
          user.value.email = response.data.data.user.email;
        })
        .catch((error) => {
          console.error("Error in Axios request:", error);
        });
    });
  });
  axios.defaults.withCredentials = true;
  axios.defaults.baseURL = "http://localhost:8000";

  const modifyUser = () => {
    if (action.value == 1) {
      axios.get("/sanctum/csrf-cookie").then((response) => {
        axios
          .put("/api/users/" + user.value.id, user.value)
          .then((response) => {
            console.log(response.data.data);
          })
          .catch((error) => {
            console.error("Error in Axios request:", error);
          });
      });
    } else if (action.value == 2) {
      axios.get("/sanctum/csrf-cookie").then((response) => {
        axios
          .post("/api/change-password/" + user.value.id, password.value)
          .then((response) => {
            console.log(response.data.data);
          })
          .catch((error) => {
            console.error("Error in Axios request:", error);
          });
      });
    }
    deleteItemsDialog.value = false;
  };
</script>

<template>
  <div class="grid card">
    <div class="col-12 lg:col-4">
      <div class="card">
        <div class="text-center mb-5">
          <div class="text-900 text-3xl font-medium mb-3">
            Welcome, {{ user.name }}!
          </div>
        </div>
        <div class="text-center">
          {{ action }}
          <ul>
            <li
              class="flex align-items-center py-3 px-2 border-top-1 surface-border flex-wrap"
            >
              <div class="text-500 w-6 md:w-2 font-medium">Name</div>
              <div class="text-900 w-full md:w-8 md:flex-order-0 flex-order-1">
                {{ user.name }}
              </div>
              <div class="w-6 md:w-2 flex justify-content-end"></div>
            </li>
            <li class="flex align-items-center py-3 px-2 flex-wrap">
              <div class="text-500 w-6 md:w-2 font-medium">Surname</div>
              <div class="text-900 w-full md:w-8 md:flex-order-0 flex-order-1">
                {{ user.surname }}
              </div>
              <div class="w-6 md:w-2 flex justify-content-end"></div>
            </li>

            <li class="flex align-items-center py-3 px-2 flex-wrap">
              <div class="text-500 w-6 md:w-2 font-medium">Lives</div>
              <div class="text-900 w-full md:w-8 md:flex-order-0 flex-order-1">
                {{ user.address }}
              </div>
              <div class="w-6 md:w-2 flex justify-content-end"></div>
            </li>

            <li class="flex align-items-center py-3 px-2 flex-wrap">
              <div class="text-500 w-6 md:w-2 font-medium">Email</div>
              <div class="text-900 w-full md:w-8 md:flex-order-0 flex-order-1">
                {{ user.email }}
              </div>
              <div class="w-6 md:w-2 flex justify-content-end"></div>
            </li>
            <li class="flex align-items-center py-3 px-2 flex-wrap">
              <div class="text-500 w-6 md:w-2 font-medium">Contact</div>
              <div class="text-900 w-full md:w-8 md:flex-order-0 flex-order-1">
                (+216) {{ user.mobile }}
              </div>
              <div class="w-6 md:w-2 flex justify-content-end"></div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-12 lg:col-8">
      <TabView>
        <div class="card">
          <TabPanel header="Offers" class="card">
            <div class="card">
              <div>
                <Offer :isAdmin="isAdmin"></Offer>
              </div>
            </div>
          </TabPanel>
        </div>
        <TabPanel header="Recruitments">
          <div class="card">
            <div>
              <Recruitments></Recruitments>
            </div>
          </div>
        </TabPanel>
      </TabView>
    </div>
  </div>
  <Dialog
    v-model:visible="deleteItemsDialog"
    :style="{ width: '450px' }"
    header="Confirm"
    :modal="true"
  >
    <div class="flex align-items-center justify-content-center">
      <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
      <span>Are you sure you want to delete the selected Items?</span>
    </div>
    <template #footer>
      <Button
        label="No"
        icon="pi pi-times"
        class="p-button-text"
        @click="deleteItemsDialog = false"
      />
      <Button
        label="Yes"
        icon="pi pi-check"
        class="p-button-text"
        @click="modifyUser"
      />
    </template>
  </Dialog>
</template>
