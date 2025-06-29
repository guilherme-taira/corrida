<template>
    <v-app class="fundo-cinza">
        <v-container class="pt-0">
            <!-- Banner Melhorado -->
            <v-row class="mb-8 pt-10">
                <v-col cols="12">
                    <v-img
                        src="/images/heading-bg.jpg"
                        height="360"
                        class="rounded-xl elevation-6"
                        cover
                    >
                        <div
                            class="banner-overlay d-flex flex-column align-center justify-center text-center"
                        >
                            <h1 class="text-white text-h3 font-weight-bold">
                                Resultados Oficiais
                            </h1>
                            <h2 class="text-white text-h5 font-italic">
                                FORLIFE SPORTS
                            </h2>
                        </div>
                    </v-img>
                </v-col>
            </v-row>

            <!-- Cards de Eventos -->
            <v-row>
                <v-col
                    v-for="evento in eventos"
                    :key="evento.id"
                    cols="12"
                    sm="6"
                    md="4"
                >
                    <router-link
                        :to="{
                            name: 'corridaDetalhe',
                            params: { id: evento.id },
                        }"
                        class="text-center v-card v-card--hover v-card--link v-sheet theme--dark rounded-lg elevation-4"
                        style="
                            height: 100%;
                            background-color: #2c2c2c;
                            text-decoration: none;
                        "
                        custom
                        v-slot="{ navigate }"
                    >
                        <a @click="navigate" tabindex="0">
                            <!-- Data -->
                            <div
                                class="v-card__subtitle text-center py-2"
                                style="
                                    background-color: #FFFFFFFF;
                                    color: #000;
                                    font-weight: bold;
                                "
                            >
                                {{ formatarData(evento.created_at) }}
                            </div>

                            <!-- Conteúdo -->
                            <div class="v-card__text pa-3">
                                <v-row no-gutters align="center">
                                    <!-- Imagem -->
                                    <v-col cols="4">
                                        <v-img
                                            :src="
                                                evento.imagem
                                                    ? `/storage/${evento.imagem}`
                                                    : '/storage/corridas/corrida-generica.png'
                                            "
                                            height="90"
                                            width="90"
                                            cover
                                            class="rounded-lg"
                                        />
                                    </v-col>

                                    <!-- Texto -->
                                    <v-col cols="8" class="pl-3">
                                        <div
                                            class="text-subtitle-2 white--text font-weight-medium"
                                        >
                                            {{ evento.cidade ?? '' }}
                                        </div>
                                        <div
                                            class="primary--text text-body-1 font-weight-bold"
                                        >
                                            {{ evento.name }}
                                        </div>
                                        <div class="grey--text text-caption">
                                             Local {{ evento.local ?? ' não informado' }}
                                        </div>
                                    </v-col>
                                </v-row>
                            </div>
                        </a>
                    </router-link>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const eventos = ref([]);

onMounted(() => {
    axios.get(`${window.location.origin}/api/eventos`)
        .then((response) => {
            eventos.value = response.data.sort((a, b) => {
                return new Date(b.created_at) - new Date(a.created_at); // DESC
            });
        })
        .catch((error) => {
            console.error("Erro ao carregar eventos:", error);
        });
});

function formatarData(data) {
    return new Date(data).toLocaleDateString("pt-BR");
}
</script>

<style scoped>
.fundo-cinza {
    background-color: #5f5f5f;
}

.v-card {
    color: white;
    transition: transform 0.2s ease-in-out;
}

.v-card:hover {
    transform: translateY(-5px);
}

.banner-overlay {
    height: 100%;
    background: rgba(0, 0, 0, 0.45);
    padding: 20px;
    text-shadow: 1px 1px 2px black;
}
</style>
