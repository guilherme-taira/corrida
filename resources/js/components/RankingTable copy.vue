<template>
    <v-app dark>
        <v-container class="pa-6 fundo-escuro">
            <!-- Banner -->
            <v-img :src="bannerUrl" class="mb-6 rounded-lg elevation-3" />

            <!-- Abas -->
            <v-tabs
                v-model="abaSelecionada"
                background-color="highlight"
                centered
                dark
            >
                <v-tab><v-icon start>mdi-medal</v-icon>Premiação</v-tab>
                <v-tab><v-icon start>mdi-account-group</v-icon>Inscritos</v-tab>
            </v-tabs>

            <!-- Modal de Filtros -->
            <v-dialog v-model="mostrarModalFiltro" max-width="900" scrollable>
                <v-card class="pa-4 rounded-lg">
                    <v-card-title
                        class="d-flex justify-space-between align-center"
                    >
                        <span class="text-h6">Filtros Avançados</span>
                        <v-btn icon @click="mostrarModalFiltro = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-card-title>

                    <v-card-text>
                        <v-row dense>
                            <!-- Filtros -->
                            <v-col cols="12" md="3">
                                <v-select
                                    v-model="filtros.premiacao"
                                    :items="['Todos', ...opcoes.premiacao]"
                                    label="Premiação"
                                    dense
                                    outlined
                                    prepend-icon="mdi-trophy"
                                />
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-select
                                    v-model="filtros.modalidade"
                                    :items="['Todos', ...opcoes.modalidade]"
                                    label="Modalidade"
                                    dense
                                    outlined
                                    prepend-icon="mdi-run"
                                />
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-select
                                    v-model="filtros.sexo"
                                    :items="['Todos', ...opcoes.sexo]"
                                    label="Sexo"
                                    dense
                                    outlined
                                    prepend-icon="mdi-gender-male-female"
                                />
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-select
                                    v-model="filtros.equipe"
                                    :items="['Todos', ...opcoes.equipe]"
                                    label="Equipe"
                                    dense
                                    outlined
                                    prepend-icon="mdi-account-group"
                                />
                            </v-col>

                            <!-- Filtros por texto -->
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="filtros.nome"
                                    label="Pesquisar por Nome"
                                    dense
                                    outlined
                                    prepend-icon="mdi-account-search"
                                    clearable
                                />
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-text-field
                                    v-model="filtros.realbib"
                                    label="Número de Peito"
                                    dense
                                    outlined
                                    prepend-icon="mdi-numeric"
                                    clearable
                                    type="number"
                                />
                            </v-col>
                            <v-col
                                cols="12"
                                md="3"
                                class="d-flex justify-end align-end"
                            >
                                <v-btn
                                    color="primary"
                                    variant="tonal"
                                    prepend-icon="mdi-filter-remove"
                                    @click="limparFiltros"
                                    block
                                >
                                    Limpar Filtros
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-dialog>

            <!-- Tabela com paginação -->
            <v-data-table
                :headers="headers"
                :items="filtrados"
                :items-per-page="10"
                class="elevation-1 rounded-lg"
                :show-select="false"
            >
                <!-- Ícones da posição -->
                <template v-slot:item.rank="{ item }">
                    <div class="text-center font-weight-bold">
                        <span v-if="item.rank == 1" class="text-warning"
                            >🥇</span
                        >
                        <span
                            v-else-if="item.rank == 2"
                            class="text-grey-lighten-2"
                            >🥈</span
                        >
                        <span v-else-if="item.rank == 3" class="text-amber"
                            >🥉</span
                        >
                        <span v-else class="text-highlight">{{
                            item.rank
                        }}</span>
                    </div>
                </template>

                <!-- Coluna número -->
                <template v-slot:item.realbib="{ item }">
                    <div class="text-center">{{ item.realbib }}</div>
                </template>

                <!-- Coluna nome com clique -->
                <template v-slot:item.nome="{ item }">
                    <span
                        class="text-primary font-weight-medium"
                        style="cursor: pointer"
                        @click="verDetalhes(item)"
                    >
                        {{ item.nome }}
                    </span>
                </template>

                <!-- Coluna tempo -->
                <template v-slot:item.time="{ item }">
                    <div class="text-center font-mono">{{ item.time }}</div>
                </template>

                <!-- Paginação numérica avançada -->
                <template v-slot:bottom>
                    <div
                        class="d-flex justify-center align-center pa-4 flex-wrap gap-2"
                    >
                        <v-btn
                            icon
                            @click="paginaAtual--"
                            :disabled="paginaAtual <= 1"
                            size="small"
                        >
                            <v-icon>mdi-chevron-left</v-icon>
                        </v-btn>

                        <v-btn
                            size="small"
                            :variant="paginaAtual === 1 ? 'flat' : 'text'"
                            color="primary"
                            @click="paginaAtual = 1"
                        >
                            1
                        </v-btn>

                        <span v-if="paginaAtual > 4">…</span>

                        <template
                            v-for="p in rangePages(paginaAtual, pageCount)"
                            :key="p"
                        >
                            <v-btn
                                v-if="p !== 1 && p !== pageCount"
                                size="small"
                                :variant="paginaAtual === p ? 'flat' : 'text'"
                                color="primary"
                                @click="paginaAtual = p"
                            >
                                {{ p }}
                            </v-btn>
                        </template>

                        <span v-if="paginaAtual < pageCount - 3">…</span>

                        <v-btn
                            v-if="pageCount > 1"
                            size="small"
                            :variant="
                                paginaAtual === pageCount ? 'flat' : 'text'
                            "
                            color="primary"
                            @click="paginaAtual = pageCount"
                        >
                            {{ pageCount }}
                        </v-btn>

                        <v-btn
                            icon
                            @click="paginaAtual++"
                            :disabled="paginaAtual >= pageCount"
                            size="small"
                        >
                            <v-icon>mdi-chevron-right</v-icon>
                        </v-btn>
                    </div>
                </template>
            </v-data-table>
        </v-container>

        <!-- Botão flutuante de filtro -->
        <v-btn
            icon
            color="white"
            size="large"
            class="filtro-flutuante"
            @click="mostrarModalFiltro = true"
        >
            <v-icon color="primary">mdi-magnify</v-icon>
        </v-btn>
    </v-app>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

// Props
const props = defineProps({
    corridaId: String,
});

// Router e estados principais
const router = useRouter();
const corredores = ref([]);
const banner = ref("");
const abaSelecionada = ref(0);
const mostrarModalFiltro = ref(false);

// Filtros iniciais
const filtros = ref({
    premiacao: "Todos",
    modalidade: "Todos",
    sexo: "Todos",
    equipe: "Todos",
    nome: "",
    realbib: "",
});

// Cabeçalhos da tabela
const headers = [
    { title: "Posição", key: "rank", align: "center" },
    { title: "Número", key: "realbib", align: "center" },
    { title: "Nome", key: "nome", align: "start" },
    { title: "Tempo", key: "time", align: "center" },
];

// Carrega dados da corrida
onMounted(async () => {
    try {
        const response = await axios.get(`/api/v1/corridas/${props.corridaId}`);
        corredores.value = response.data.dados;
        banner.value = response.data.banner;
    } catch (error) {
        console.error("Erro ao carregar corredores:", error);
        corredores.value = [];
    }
});

// Gera opções únicas para os selects
const opcoes = computed(() => {
    const values = {
        premiacao: new Set(),
        modalidade: new Set(),
        sexo: new Set(),
        equipe: new Set(),
    };

    corredores.value.forEach((corredor) => {
        if (corredor.race) values.premiacao.add(corredor.race);
        if (corredor.category) values.modalidade.add(corredor.category);
        if (corredor.sex) values.sexo.add(corredor.sex);
        if (corredor.team) values.equipe.add(corredor.team);
    });

    return {
        premiacao: Array.from(values.premiacao),
        modalidade: Array.from(values.modalidade),
        sexo: Array.from(values.sexo),
        equipe: Array.from(values.equipe),
    };
});

// Computa e filtra os dados + ordena se necessário
const filtrados = computed(() => {
    const lista = corredores.value
        .map((c) => ({
            ...c,
            nome: `${c.firstname ?? ""} ${c.lastname ?? ""}`.trim(),
        }))
        .filter(
            (c) =>
                (filtros.value.premiacao === "Todos" ||
                    c.race === filtros.value.premiacao) &&
                (filtros.value.modalidade === "Todos" ||
                    c.category === filtros.value.modalidade) &&
                (filtros.value.sexo === "Todos" ||
                    c.sex === filtros.value.sexo) &&
                (filtros.value.equipe === "Todos" ||
                    c.team === filtros.value.equipe)
        )
        .filter((c) =>
            filtros.value.nome
                ? c.nome
                      .toLowerCase()
                      .normalize("NFD")
                      .replace(/[\u0300-\u036f]/g, "")
                      .includes(
                          filtros.value.nome
                              .toLowerCase()
                              .normalize("NFD")
                              .replace(/[\u0300-\u036f]/g, "")
                      )
                : true
        )
        .filter((c) =>
            filtros.value.realbib
                ? String(c.realbib).includes(String(filtros.value.realbib))
                : true
        );

    // Verifica se algum filtro de categoria foi usado
    const temFiltroDeCategoria =
        filtros.value.premiacao !== "Todos" ||
        filtros.value.modalidade !== "Todos" ||
        filtros.value.sexo !== "Todos" ||
        filtros.value.equipe !== "Todos";

    // Verifica se há busca por nome ou número
    const temBusca = filtros.value.nome !== "" || filtros.value.realbib !== "";

    // Só recalcula rank geral se NÃO houver filtros nem busca
    if (!temFiltroDeCategoria && !temBusca) {
        lista.sort((a, b) => {
            const tA = a.time?.split(":").map(Number) || [99, 99, 99];
            const tB = b.time?.split(":").map(Number) || [99, 99, 99];
            const segA = tA[0] * 3600 + tA[1] * 60 + tA[2];
            const segB = tB[0] * 3600 + tB[1] * 60 + tB[2];
            return segA - segB;
        });

        lista.forEach((item, index) => {
            item.rank = index + 1;
        });
    }

    return lista;
});

// Redireciona para detalhes do atleta
function verDetalhes(atleta) {
    router.push({
        name: "atleta",
        params: { id: atleta.bib },
        state: {
            ...atleta,
            corrida: props.corridaId,
        },
    });
}

const paginaAtual = ref(1)

const pageCount = computed(() => {
  return Math.ceil(filtrados.value.length / 10)
})

function rangePages(current, total) {
  const pages = []
  const start = Math.max(2, current - 2)
  const end = Math.min(total - 1, current + 2)

  for (let i = start; i <= end; i++) {
    pages.push(i)
  }

  return pages
}
// Reseta os filtros
function limparFiltros() {
    filtros.value = {
        premiacao: "Todos",
        modalidade: "Todos",
        sexo: "Todos",
        equipe: "Todos",
        nome: "",
        realbib: "",
    };
}

// URL do banner
const bannerUrl = computed(() => {
    return banner.value ? `/storage/${banner.value}` : "";
});
</script>

<style scoped>
.text-highlight {
    color: #000000;
}
.filtro-flutuante {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 999;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
}
</style>
