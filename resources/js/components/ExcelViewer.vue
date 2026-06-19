<template>
    <v-container fluid class="page-wrapper">
        <v-card elevation="2">
            <v-card-title class="dashboard-title">
                Central de Dados da Corrida
            </v-card-title>
            <v-card-text>
                <!-- KPIs -->
                <v-row class="mb-4">
                    <v-col cols="12" md="3">
                        <v-card class="kpi-card kpi-total">
                            <v-card-title>{{
                                totalParticipantes
                            }}</v-card-title>
                            <v-card-subtitle>Participantes</v-card-subtitle>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="3">
                        <v-card class="kpi-card kpi-masc">
                            <v-card-title>{{ totalMasculino }}</v-card-title>
                            <v-card-subtitle>Masculino</v-card-subtitle>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="3">
                        <v-card class="kpi-card kpi-fem">
                            <v-card-title>{{ totalFeminino }}</v-card-title>
                            <v-card-subtitle>Feminino</v-card-subtitle>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="3">
                        <v-card class="kpi-card kpi-equipes">
                            <v-card-title>{{ totalEquipes }}</v-card-title>
                            <v-card-subtitle>Equipes</v-card-subtitle>
                        </v-card>
                    </v-col>
                </v-row>

                <!-- Filtros -->
                <v-card class="filtro-card">
                    <v-row>
                        <v-col cols="12" md="3">
                            <v-text-field
                                v-model="search"
                                label="Pesquisar atleta"
                                prepend-inner-icon="mdi-magnify"
                                clearable
                            />
                        </v-col>

                        <v-col cols="12" md="2">
                            <v-select
                                v-model="filtroSexo"
                                :items="['M', 'F']"
                                label="Sexo"
                                clearable
                            />
                        </v-col>

                        <v-col cols="12" md="2">
                            <v-select
                                v-model="filtroModalidade"
                                :items="modalidades"
                                label="Modalidade"
                                clearable
                            />
                        </v-col>

                        <v-col cols="12" md="2">
                            <v-text-field
                                v-model="filtroCpf"
                                label="CPF"
                                prepend-inner-icon="mdi-card-account-details"
                                clearable
                            />
                        </v-col>

                        <v-col cols="12" md="3">
                            <v-text-field
                                v-model="filtroEquipe"
                                label="Equipe"
                                prepend-inner-icon="mdi-account-group"
                                clearable
                            />
                        </v-col>
                    </v-row>
                </v-card>

                <div class="contador-registros">
                    Mostrando
                    <strong>{{ itemsFiltrados.length }}</strong>
                    de
                    <strong>{{ items.length }}</strong>
                    registros
                </div>

                <v-data-table
                    :headers="headers"
                    :items="itemsFiltrados"
                    :search="search"
                    fixed-header
                    height="700"
                    density="comfortable"
                    :items-per-page="50"
                >
                    <template #item.uniforme="{ item }">
                        <v-checkbox
                            :model-value="item.UNIFORM_ENTREGUE"
                            color="success"
                            hide-details
                            @click="abrirEntrega(item)"
                        />
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>

        <v-dialog
    v-model="dialogEntrega"
    max-width="500"
>
    <v-card>

        <v-card-title>
            Confirmar Entrega
        </v-card-title>

        <v-card-text>

            Deseja registrar a entrega do uniforme para:

            <br><br>

            <strong>
                {{ atletaSelecionado?.NOME }}
            </strong>

            <br>

            CPF:
            {{ atletaSelecionado?.CPF }}

        </v-card-text>

        <v-card-actions>

            <v-spacer />

            <v-btn
                color="grey"
                @click="dialogEntrega = false"
            >
                Cancelar
            </v-btn>

            <v-btn
                color="success"
                @click="confirmarEntrega"
            >
                Confirmar
            </v-btn>

        </v-card-actions>

    </v-card>
</v-dialog>
    </v-container>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { useRoute } from "vue-router";

const route = useRoute();

const search = ref("");

const headers = ref([]);
const items = ref([]);

const filtroSexo = ref(null);
const filtroEquipe = ref("");
const filtroModalidade = ref(null);
const filtroCpf = ref("");
const dialogEntrega = ref(false);
const atletaSelecionado = ref(null);

onMounted(async () => {
    const { data } = await axios.get(`/api/excel/${route.params.id}`);

    const headersOriginais = data.headers;

    // Oculta CHIP
    const indicesOcultos = [1];

    headers.value = headersOriginais
        .filter((_, index) => !indicesOcultos.includes(index))
        .map((col) => ({
            title: col,
            key: col,
            sortable: true,
        }));

        headers.value = headersOriginais
    .filter((col, index) =>
        !indicesOcultos.includes(index) &&
        col !== "UNIFORM_ENTREGUE"
    )
    .map(col => ({
        title: col,
        key: col,
        sortable: true,
    }));

    headers.value.push({
        title: "KITS",
        key: "uniforme",
        sortable: false,
    });

    items.value = data.rows.map((row) => {
        const obj = {};

        headersOriginais.forEach((header, index) => {
            if (indicesOcultos.includes(index)) {
                return;
            }

            obj[header] = row[index];
        });

        return obj;
    });
});
function abrirEntrega(item) {
    if (item.UNIFORM_ENTREGUE) {
        return;
    }

    atletaSelecionado.value = item;
    dialogEntrega.value = true;
}

async function confirmarEntrega() {

    try {

        await axios.post("/uniforme/entregar", {
            corrida_id: route.params.id,
            cpf: atletaSelecionado.value.CPF
        });

        dialogEntrega.value = false;

        location.reload();

    } catch (error) {

        console.error(error);
        alert("Erro ao registrar entrega");
    }
}

const modalidades = computed(() => {
    return [
        ...new Set(items.value.map((item) => item.MOD).filter(Boolean)),
    ].sort();
});

const itemsFiltrados = computed(() => {
    return items.value.filter((item) => {
        if (filtroSexo.value && item.SEXO !== filtroSexo.value) {
            return false;
        }

        if (
            filtroEquipe.value &&
            !String(item.EQUIPE || "")
                .toLowerCase()
                .includes(filtroEquipe.value.toLowerCase())
        ) {
            return false;
        }

        if (filtroModalidade.value && item.MOD !== filtroModalidade.value) {
            return false;
        }

        if (
            filtroCpf.value &&
            !String(item.CPF || "").includes(filtroCpf.value)
        ) {
            return false;
        }

        return true;
    });
});

const totalParticipantes = computed(() => itemsFiltrados.value.length);

const totalMasculino = computed(
    () => itemsFiltrados.value.filter((item) => item.SEXO === "M").length,
);

const totalFeminino = computed(
    () => itemsFiltrados.value.filter((item) => item.SEXO === "F").length,
);

const totalEquipes = computed(
    () =>
        new Set(itemsFiltrados.value.map((item) => item.EQUIPE).filter(Boolean))
            .size,
);
</script>

<style scoped>
.page-wrapper {
    background: #f1f5f9;
    min-height: 100vh;
    padding-bottom: 30px;
}

.dashboard-title {
    font-size: 32px;
    font-weight: 700;
    color: #1e293b;
    padding: 20px;
}

.kpi-card {
    border-radius: 16px;
    transition: all 0.2s ease;
}

.kpi-card:hover {
    transform: translateY(-3px);
}

.kpi-total {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: white;
}

.kpi-masc {
    background: linear-gradient(135deg, #0284c7, #38bdf8);
    color: white;
}

.kpi-fem {
    background: linear-gradient(135deg, #db2777, #f472b6);
    color: white;
}

.kpi-equipes {
    background: linear-gradient(135deg, #16a34a, #4ade80);
    color: white;
}

.kpi-card .v-card-title {
    font-size: 34px;
    font-weight: 700;
}

.kpi-card .v-card-subtitle {
    color: rgba(255, 255, 255, 0.9) !important;
}

.filtro-card {
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 20px;
}

.contador-registros {
    font-size: 15px;
    margin-bottom: 15px;
    color: #475569;
}

:deep(.v-data-table) {
    border-radius: 16px;
    overflow: hidden;
}

:deep(.v-data-table-header th) {
    background: #1e3a8a !important;
    color: white !important;
    font-weight: 700 !important;
    text-transform: uppercase;
}

:deep(.v-data-table tbody tr:nth-child(even)) {
    background-color: #f8fafc;
}

:deep(.v-data-table tbody tr:hover) {
    background-color: #dbeafe !important;
    transition: 0.15s;
}
</style>



