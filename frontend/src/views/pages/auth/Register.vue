<script setup>
  import { useLayout } from "@/layout/composables/layout";
  import { ref, computed } from "vue";
  import axios from "axios";
  import AppConfig from "@/layout/AppConfig.vue";
  import { useRouter } from "vue-router";
  import { useToast } from "primevue/usetoast";
  const toast = useToast();
  const { layoutConfig } = useLayout();
  const credentials = ref({
    email: "",
    password: "",
    name: "",
    surname: "",
    address: "",
    mobile: "",
  });

  const showInfo = () => {
    toast.add({
      severity: "info",
      summary: "Info Message",
      detail: "Please verify your email",
      life: 3000,
    });
  };

  const router = useRouter();
  const user = ref([]);

  axios.defaults.withCredentials = true;
  axios.defaults.baseURL = "http://localhost:8000";

  function login() {
    axios.get("/sanctum/csrf-cookie").then((response) => {
      axios
        .post("/api/register", credentials.value)
        .then((response) => {
          user.value = response.data.data;
          showInfo();
        })
        .catch((error) => {
          console.error(error);
        });
    });

    // router.push("/dashboard");
  }

  const logoUrl = computed(() => {
    return `layout/images/${
      layoutConfig.darkTheme.value ? "logo-white" : "logo-dark"
    }.svg`;
  });
</script>

<template>
  <Toast />
  <div
    class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden"
  >
    <div class="flex flex-column align-items-center justify-content-center">
      <div
        style="
          border-radius: 56px;
          padding: 0.3rem;
          background: linear-gradient(
            180deg,
            var(--primary-color) 10%,
            rgba(33, 150, 243, 0) 30%
          );
        "
      >
        <div
          class="w-full surface-card py-3 px-5 sm:px-8"
          style="border-radius: 53px"
        >
          <div class="text-center mb-5">
            <div class="text-900 text-3xl font-medium mb-3">
              Create an account
            </div>
            <span class="text-600 font-medium">Fill in this form</span>
          </div>

          <div>
            <label class="block text-900 text-xl font-medium mb-2">Name</label>
            <InputText
              id="nom"
              type="text"
              placeholder="Name"
              class="w-full md:w-30rem mb-5"
              style="padding: 1rem"
              v-model="credentials.name"
            />

            <label for="surname" class="block text-900 text-xl font-medium mb-2"
              >Surname</label
            >
            <InputText
              id="surname"
              type="text"
              placeholder="Surname "
              class="w-full md:w-30rem mb-5"
              style="padding: 1rem"
              v-model="credentials.surname"
            />

            <label for="mobile" class="block text-900 text-xl font-medium mb-2"
              >Mobile</label
            >
            <InputText
              id="mobile"
              type="text"
              placeholder="Mobile "
              class="w-full md:w-30rem mb-5"
              style="padding: 1rem"
              v-model="credentials.mobile"
            />

            <label for="address" class="block text-900 text-xl font-medium mb-2"
              >Address</label
            >
            <InputText
              id="address"
              type="text"
              placeholder="Address "
              class="w-full md:w-30rem mb-5"
              style="padding: 1rem"
              v-model="credentials.address"
            />
            <label for="email1" class="block text-900 text-xl font-medium mb-2"
              >Email</label
            >
            <InputText
              id="email1"
              type="text"
              placeholder="Email address"
              class="w-full md:w-30rem mb-5"
              style="padding: 1rem"
              v-model="credentials.email"
            />

            <label
              for="password1"
              class="block text-900 font-medium text-xl mb-2"
              >Password</label
            >
            <Password
              id="password1"
              v-model="credentials.password"
              placeholder="Password"
              :toggleMask="true"
              class="w-full mb-3"
              inputClass="w-full"
              inputStyle="padding:1rem"
            ></Password>

            <div
              class="flex align-items-center justify-content-between mb-5 gap-5"
            ></div>
            <Button
              label="Sign up"
              class="w-full p-3 text-xl"
              @click="login"
            ></Button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .pi-eye {
    transform: scale(1.6);
    margin-right: 1rem;
  }

  .pi-eye-slash {
    transform: scale(1.6);
    margin-right: 1rem;
  }
  .google {
    background: linear-gradient(
      to left,
      var(--purple-600) 50%,
      var(--purple-700) 50%
    );
    background-size: 200% 100%;
    background-position: right bottom;
    transition: background-position 0.5s ease-out;
    border-color: var(--purple-700);
    display: flex;
    align-items: stretch;
    padding: 0;

    &:enabled:hover {
      background: linear-gradient(
        to left,
        var(--purple-600) 50%,
        var(--purple-700) 50%
      );
      background-size: 200% 100%;
      background-position: left bottom;
      border-color: var(--purple-700);
    }

    &:focus {
      box-shadow: 0 0 0 1px var(--purple-400);
    }
  }

  .twitter {
    background: linear-gradient(
      to left,
      var(--blue-400) 50%,
      var(--blue-500) 50%
    );
    background-size: 200% 100%;
    background-position: right bottom;
    transition: background-position 0.5s ease-out;
    border-color: var(--blue-500);
    padding: 0;
    display: flex;
    align-items: stretch;

    &:enabled:hover {
      background: linear-gradient(
        to left,
        var(--blue-400) 50%,
        var(--blue-500) 50%
      );
      background-size: 200% 100%;
      background-position: left bottom;
      border-color: var(--blue-500);
    }

    &:focus {
      box-shadow: 0 0 0 1px var(--blue-200);
    }
  }

  .discord {
    background: linear-gradient(
      to left,
      var(--bluegray-700) 50%,
      var(--bluegray-800) 50%
    );
    background-size: 200% 100%;
    background-position: right bottom;
    transition: background-position 0.5s ease-out;
    border-color: var(--bluegray-800);
    padding: 0;
    display: flex;
    align-items: stretch;

    &:enabled:hover {
      background: linear-gradient(
        to left,
        var(--bluegray-700) 50%,
        var(--bluegray-800) 50%
      );
      background-size: 200% 100%;
      background-position: left bottom;
      border-color: var(--bluegray-800);
    }

    &:focus {
      box-shadow: 0 0 0 1px var(--purple-500);
    }
  }

  .template-button .p-button.twitter {
    background: linear-gradient(
      to left,
      var(--blue-400) 50%,
      var(--blue-500) 50%
    );
    background-size: 200% 100%;
    background-position: right bottom;
    transition: background-position 0.5s ease-out;
    color: #fff;
    border-color: var(--blue-500);
  }
  .template-button .p-button.twitter:hover {
    background-position: left bottom;
  }
  .template-button .p-button.twitter i {
    background-color: var(--blue-500);
  }
  .template-button .p-button.twitter:focus {
    box-shadow: 0 0 0 1px var(--blue-200);
  }
  .template-button .p-button.slack {
    background: linear-gradient(
      to left,
      var(--orange-400) 50%,
      var(--orange-500) 50%
    );
    background-size: 200% 100%;
    background-position: right bottom;
    transition: background-position 0.5s ease-out;
    color: #fff;
    border-color: var(--orange-500);
  }
  .template-button .p-button.slack:hover {
    background-position: left bottom;
  }
  .template-button .p-button.slack i {
    background-color: var(--orange-500);
  }
  .template-button .p-button.slack:focus {
    box-shadow: 0 0 0 1px var(--orange-200);
  }
  .template-button .p-button.amazon {
    background: linear-gradient(
      to left,
      var(--yellow-400) 50%,
      var(--yellow-500) 50%
    );
    background-size: 200% 100%;
    background-position: right bottom;
    transition: background-position 0.5s ease-out;
    color: #000;
    border-color: var(--yellow-500);
  }
  .template-button .p-button.amazon:hover {
    background-position: left bottom;
  }
  .template-button .p-button.amazon i {
    background-color: var(--yellow-500);
  }
  .template-button .p-button.amazon:focus {
    box-shadow: 0 0 0 1px var(--yellow-200);
  }
  .template-button .p-button.discord {
    background: linear-gradient(
      to left,
      var(--bluegray-700) 50%,
      var(--bluegray-800) 50%
    );
    background-size: 200% 100%;
    background-position: right bottom;
    transition: background-position 0.5s ease-out;
    color: #fff;
    border-color: var(--bluegray-800);
  }
  .template-button .p-button.discord:hover {
    background-position: left bottom;
  }
  .template-button .p-button.discord i {
    background-color: var(--bluegray-800);
  }
  .template-button .p-button.discord:focus {
    box-shadow: 0 0 0 1px var(--bluegray-500);
  }
  @media screen and (max-width: 960px) {
    -button .p-button {
      margin-bottom: 0.5rem;
    }
    -button .p-button:not(.p-button-icon-only) {
      display: flex;
      flex-wrap: wrap;
    }
    -button .p-buttonset .p-button {
      margin-bottom: 0;
    }
  }
</style>
