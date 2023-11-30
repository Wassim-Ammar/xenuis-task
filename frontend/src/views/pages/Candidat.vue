<style>
  .flex-right {
    display: flex;
    justify-content: flex-end;
  }
</style>
<script setup>
  import { ref, onMounted } from "vue";

  import axios from "axios";

  import { provide } from "vue";
  import Education from "./Education.vue";
  import Offer from "./Offer.vue";
  import TabView from "primevue/tabview";
  import TabPanel from "primevue/tabpanel";
  import Experiences from "./Experiences.vue";
  import { useToast } from "primevue/usetoast";

  const toast = useToast();
  const isAdmin = 0;

  const showSuccess = () => {
    toast.add({
      severity: "success",
      summary: "success",
      detail: "Action succeded",
      life: 3000,
    });
  };

  const deleteItemDialog = ref(false);
  const productDialog = ref(false);

  const textable = ref(false);

  const proExp = ref([]);

  const education = ref([]);

  provide("arrayData", proExp);
  provide("eduData", education);
  const action = ref("");
  const request = ref(true);
  const user = ref({
    name: "",
    surname: "",
    email: "",
    mobile: "",
    address: "",
    city: "",
    createCv: "",
    experience: proExp.value,
    education: education.value,
  });

  const step = ref(1);

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
  const editProduct = (editProduct) => {
    product.value = { ...editProduct };
    console.log(product);
    productDialog.value = true;
  };

  const submitCV = () => {
    {
      {
        axios
          .post("/api/add-cv", {
            user: user.value,
            experience: proExp.value,
            education: education.value,
          })
          .then((response) => {
            showSuccess();
            user.value = response.data.data;
            console.log(response.data.data);
            user.value.email = response.data.data.user.email;
          })
          .catch((error) => {
            console.error("Error in Axios request:", error);
          });
      }
    }
    deleteItemDialog.value = false;
  };
</script>

<template>
  <Toast />
  <div class="grid card">
    <div class="col-12 lg:col-4">
      <div class="card">
        <div class="text-center mb-5">
          <div class="text-900 text-3xl font-medium mb-3">
            Welcome, {{ user.name }}!
          </div>
          <span class="text-600 font-medium">{{ user.role }}</span>
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
      <div class="card">
        <TabView>
          <TabPanel header="Profile">
            <div v-if="step == 1">
              <div class="col-12 mb-0 lg:col-4 lg:mb-0">
                <div class="font-medium text-3xl text-900">Create CV</div>
              </div>

              <ul class="list-none p-0 mb-2">
                <li
                  class="flex align-items-center py-1 px-2 border-top-1 surface-border flex-wrap"
                >
                  <div class="text-500 w-6 md:w-2 font-medium">Name</div>
                  <div
                    class="text-900 w-full md:w-8 md:flex-order-0 flex-order-1"
                  >
                    <div class="col-12 mb-0 lg:col-4 lg:mb-0">
                      <InputText
                        type="text"
                        v-model="user.name"
                        :value="user.name"
                        :disabled="textable"
                      ></InputText>
                    </div>
                  </div>
                  <div class="w-6 md:w-2 flex justify-content-end"></div>
                </li>
                <li
                  class="flex align-items-center py-1 px-2 border-top-1 surface-border flex-wrap"
                >
                  <div class="text-500 w-6 md:w-2 font-medium">Surname</div>
                  <div
                    class="text-900 w-full md:w-8 md:flex-order-0 flex-order-1"
                  >
                    <div class="col-12 mb-0 lg:col-4 lg:mb-0">
                      <InputText
                        type="text"
                        v-model="user.surname"
                        :value="user.surname"
                        :disabled="textable"
                      ></InputText>
                    </div>
                  </div>
                  <div class="w-6 md:w-2 flex justify-content-end"></div>
                </li>

                <li
                  class="flex align-items-center py-1 px-2 border-top-1 surface-border flex-wrap"
                >
                  <div class="text-500 w-6 md:w-2 font-medium">Email</div>
                  <div
                    class="text-900 w-full md:w-8 md:flex-order-0 flex-order-1"
                  >
                    <div class="col-12 mb-2 lg:col-4 lg:mb-0">
                      <InputText
                        type="text"
                        v-model="user.email"
                        :value="user.email"
                        :disabled="textable"
                      ></InputText>
                    </div>
                  </div>
                  <div class="w-6 md:w-2 flex justify-content-end"></div>
                </li>
                <li
                  class="flex align-items-center py-1 px-2 border-top-1 surface-border flex-wrap"
                >
                  <div class="text-500 w-6 md:w-2 font-medium">Mobile</div>
                  <div
                    class="text-900 w-full md:w-8 md:flex-order-0 flex-order-1"
                  >
                    <div class="col-12 mb-2 lg:col-4 lg:mb-0">
                      <InputText
                        type="text"
                        v-model="user.mobile"
                        :value="user.mobile"
                        :disabled="textable"
                      ></InputText>
                    </div>
                  </div>
                  <div class="w-6 md:w-2 flex justify-content-end"></div>
                </li>
                <li
                  class="flex align-items-center py-1 px-2 border-top-1 surface-border flex-wrap"
                >
                  <div class="text-500 w-6 md:w-2 font-medium">Address</div>
                  <div
                    class="text-900 w-full md:w-8 md:flex-order-0 flex-order-1"
                  >
                    <div class="col-12 mb-2 lg:col-6 lg:mb-0">
                      <Textarea
                        type="text"
                        v-model="user.address"
                        :value="user.address"
                        :disabled="textable"
                      ></Textarea>
                    </div>
                  </div>
                  <div class="w-6 md:w-2 flex justify-content-end"></div>
                </li>
              </ul>

              <div class="grid justify-content-end mt-10">
                <div class="flex-right">
                  <Button
                    label="Next"
                    class="p-button-help"
                    @click="
                      () => {
                        step++;
                      }
                    "
                  >
                  </Button>
                </div>
              </div>
            </div>
            <div v-if="step == 2">
              <Experiences :proExp="proExp"></Experiences>

              <div class="grid justify-content-center mt-10 py-4">
                <div class="flex-right mr-2">
                  <Button label="Back" @click="step--" />
                </div>
                <div class="flex-right">
                  <Button
                    label="Next"
                    class="p-button-help"
                    @click="
                      () => {
                        step++;
                      }
                    "
                  >
                  </Button>
                </div>
              </div>
            </div>

            <div v-if="step == 3">
              <Education :proExp="proExp"></Education>

              <div class="grid justify-content-center mt-10 py-4">
                <div class="flex-right mr-2">
                  <Button label="Back" @click="step--" />
                </div>
                <div class="flex-right">
                  <Button
                    label="Submit"
                    class="p-button-help"
                    @click="
                      () => {
                        deleteItemDialog = true;
                      }
                    "
                  >
                  </Button>
                </div>
              </div>
            </div>
          </TabPanel>
          <TabPanel v-if="user.createCv == true" header="Offers">
            <div>
              <Offer :isAdmin="isAdmin"></Offer>
            </div>
          </TabPanel>
        </TabView>
      </div>
    </div>
  </div>
  <Dialog
    v-model:visible="deleteItemDialog"
    :style="{ width: '450px' }"
    header="Confirm"
    :modal="true"
  >
    <div class="flex align-items-center justify-content-center">
      <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
      <span>Are you sure you want to submit your CV?</span>
    </div>
    <template #footer>
      <Button
        label="No"
        icon="pi pi-times"
        class="p-button-text"
        @click="deleteItemDialog = false"
      />
      <Button
        label="Yes"
        icon="pi pi-check"
        class="p-button-text"
        @click="submitCV"
      />
    </template>
  </Dialog>
</template>
