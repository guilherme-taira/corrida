<template>
    <v-app dark>
        <v-container class="pa-6 fundo-escuro">
            <!-- Banner -->
            <v-img :src="bannerUrl" class="mb-6 rounded-lg elevation-3" />

            <!-- Chips com filtros ativos -->
            <v-row v-if="filtrosAtivos?.length" class="mb-2">
                <v-col>
                    <div class="text-caption text-black-1 mb-1">
                        Filtros ativos:
                    </div>
                    <v-chip-group column>
                        <v-chip
                            v-for="(valor, index) in filtrosAtivos"
                            :key="index"
                            class="ma-1"
                            color="primary"
                            text-color="white"
                            variant="flat"
                            size="small"
                        >
                            {{ valor }}
                        </v-chip>
                    </v-chip-group>
                </v-col>
            </v-row>

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

            <!-- Conteúdo das Abas -->
            <v-tabs-items v-model="abaSelecionada">
                <!-- Aba 1: Inscritos -->
                <v-tab-item>
                    <!-- Modal de Filtros -->
                    <v-dialog
                        v-model="mostrarModalFiltro"
                        max-width="900"
                        scrollable
                    >
                        <v-card class="pa-4 rounded-lg">
                            <v-card-title
                                class="d-flex justify-space-between align-center"
                            >
                                <span class="text-h6">Filtros Avançados</span>
                            </v-card-title>
                            <v-card-text>
                                <v-row dense>
                                    <v-col cols="12" md="3">
                                        <v-select
                                            v-model="filtros.premiacao"
                                            :items="[
                                                'Todos',
                                                ...opcoes.premiacao,
                                            ]"
                                            label="Premiação"
                                            dense
                                            outlined
                                            prepend-icon="mdi-trophy"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="3">
                                        <v-select
                                            v-model="filtros.categorias"
                                            :items="opcoes.categorias"
                                            multiple
                                            label="categorias"
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
                                            label="Número do atleta"
                                            dense
                                            outlined
                                            prepend-icon="mdi-numeric"
                                            clearable
                                            type="number"
                                        />
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="6"
                                        class="d-flex justify-end align-end flex-wrap gap-2"
                                    >
                                        <v-btn
                                            color="primary"
                                            prepend-icon="mdi-filter"
                                            @click="mostrarModalFiltro = false"
                                        >
                                            Filtrar
                                        </v-btn>
                                        <v-btn
                                            color="primary"
                                            prepend-icon="mdi-filter-remove"
                                            @click="limparFiltros"
                                        >
                                            Limpar
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-dialog>

                    <!-- Tabela de inscritos -->
                    <div class="tabela-responsiva mt-4">
                        <v-data-table
                            :headers="headers"
                            :items="filtrados"
                            v-model:page="paginaAtual"
                            :items-per-page="10"
                            class="elevation-1 rounded-lg"
                            :show-select="false"
                            hide-default-footer
                            dense
                        >
                            <template v-slot:item.rank="{ item }">
                                <div class="text-center font-weight-bold">
                                    <span
                                        v-if="item.rank == 1"
                                        class="text-warning"
                                        >🥇</span
                                    >
                                    <span
                                        v-else-if="item.rank == 2"
                                        class="text-grey-lighten-2"
                                        >🥈</span
                                    >
                                    <span
                                        v-else-if="item.rank == 3"
                                        class="text-amber"
                                        >🥉</span
                                    >
                                    <span v-else class="text-highlight">{{
                                        item.rank
                                    }}</span>
                                </div>
                            </template>

                            <template v-slot:item.realbib="{ item }">
                                <div class="text-center">
                                    {{ item.realbib }}
                                </div>
                            </template>

                            <template v-slot:item.nome="{ item }">
                                <span
                                    class="text-primary font-weight-medium"
                                    style="cursor: pointer"
                                    @click="verDetalhes(item)"
                                >
                                    {{ item.nome }}
                                </span>
                            </template>

                            <template v-slot:item.time="{ item }">
                                <div class="text-center font-mono">
                                    {{ item.time }}
                                </div>
                            </template>
                        </v-data-table>
                    </div>

                    <!-- Paginação -->
                    <div class="d-flex justify-center align-center pa-4">
                        <v-btn
                            icon
                            @click="paginaAtual = 1"
                            :disabled="paginaAtual === 1"
                            size="small"
                        >
                            <v-icon>mdi-page-first</v-icon>
                        </v-btn>
                        <v-btn
                            icon
                            @click="paginaAtual--"
                            :disabled="paginaAtual === 1"
                            size="small"
                        >
                            <v-icon>mdi-chevron-left</v-icon>
                        </v-btn>
                        <v-btn
                            icon
                            @click="paginaAtual++"
                            :disabled="paginaAtual === pageCount"
                            size="small"
                        >
                            <v-icon>mdi-chevron-right</v-icon>
                        </v-btn>
                        <v-btn
                            icon
                            @click="paginaAtual = pageCount"
                            :disabled="paginaAtual === pageCount"
                            size="small"
                        >
                            <v-icon>mdi-page-last</v-icon>
                        </v-btn>
                    </div>
                </v-tab-item>

                <!-- Aba 1: Inscritos -->
                <v-tab-item>
                    <!-- Tabela de inscritos -->
                        <v-data-table
                            :items="atletas"
                            v-model:page="paginaAtual"
                            :items-per-page="10"
                            class="elevation-1 rounded-lg"
                            hide-default-footer
                            dense
                        >
                            <template v-slot:item.realbib="{ item }">
                                <div class="text-center">
                                    {{ item.realbib }}
                                </div>
                            </template>

                            <template v-slot:item.nome="{ item }">
                                <div class="text-primary font-weight-medium">
                                    {{ item.nome }}
                                </div>
                            </template>

                            <template v-slot:item.race="{ item }">
                                <div class="text-center">{{ item.race }}</div>
                            </template>
                        </v-data-table>

                        <!-- Paginação -->
                        <div class="d-flex justify-center align-center pa-4">
                            <v-btn
                                icon
                                @click="paginaAtual = 1"
                                :disabled="paginaAtual === 1"
                                size="small"
                            >
                                <v-icon>mdi-page-first</v-icon>
                            </v-btn>
                            <v-btn
                                icon
                                @click="paginaAtual--"
                                :disabled="paginaAtual === 1"
                                size="small"
                            >
                                <v-icon>mdi-chevron-left</v-icon>
                            </v-btn>
                            <v-btn
                                icon
                                @click="paginaAtual++"
                                :disabled="paginaAtual === pageCount"
                                size="small"
                            >
                                <v-icon>mdi-chevron-right</v-icon>
                            </v-btn>
                            <v-btn
                                icon
                                @click="paginaAtual = pageCount"
                                :disabled="paginaAtual === pageCount"
                                size="small"
                            >
                                <v-icon>mdi-page-last</v-icon>
                            </v-btn>
                        </div>

                </v-tab-item>
            </v-tabs-items>
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
const atletas = ref([]);

// Filtros iniciais
const filtros = ref({
    premiacao: "Todos", // string
    categorias: [], // array (filtro múltiplo)
    sexo: "Todos", // string
    equipe: "Todos", // string
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
        // Se vier em formato JSON string, parse:
        atletas.value = Array.isArray(response.data.atletas)
            ? response.data.atletas
            : JSON.parse(response.data.atletas || "[]");
        atletas.value.forEach((a) => {
            a.nome = `${a.firstname ?? ""} ${a.lastname ?? ""}`.trim();
        });

        const lista = response.data.dados.map((c) => ({
            ...c,
            nome: `${c.firstname ?? ""} ${c.lastname ?? ""}`.trim(),
        }));

        // Ordena por tempo para rank geral
        const ordenadoGeral = [...lista].sort(
            (a, b) => tempoSegundos(a.time) - tempoSegundos(b.time)
        );
        ordenadoGeral.forEach((c, i) => (c.rank_geral = i + 1));

        // Rank por categoria (sexo + categoria)
        const grupos = {};
        ordenadoGeral.forEach((c) => {
            const chave = `${c.sex}-${c.category}`;
            if (!grupos[chave]) grupos[chave] = [];
            grupos[chave].push(c);
        });
        Object.values(grupos).forEach((grupo) => {
            grupo.forEach((c, i) => (c.rank_categoria = i + 1));
        });

        corredores.value = ordenadoGeral;
        banner.value = response.data.banner;
    } catch (error) {
        console.error("Erro ao carregar corredores:", error);
        corredores.value = [];
    }
});

function tempoSegundos(t) {
    if (!t) return 999999;
    const partes = t.split(":").map(Number);
    return (partes[0] || 0) * 3600 + (partes[1] || 0) * 60 + (partes[2] || 0);
}

const paginaAtual = ref(1);
const pageCount = computed(() => Math.ceil(filtrados.value.length / 10));

// Gera opções únicas para os selects
const opcoes = computed(() => {
    const values = {
        premiacao: new Set(),
        categorias: new Set(),
        sexo: new Set(),
        equipe: new Set(),
    };

    corredores.value.forEach((corredor) => {
        if (corredor.race) values.premiacao.add(corredor.race);
        if (corredor.category) values.categorias.add(corredor.category);
        if (corredor.sex) values.sexo.add(corredor.sex);
        if (corredor.team) values.equipe.add(corredor.team);
    });

    return {
        premiacao: Array.from(values.premiacao),
        categorias: Array.from(values.categorias),
        sexo: Array.from(values.sexo),
        equipe: Array.from(values.equipe),
    };
});

// Filtragem e ranqueamento
const filtrados = computed(() => {
    const lista = corredores.value
        .map((c) => ({
            ...c,
            nome: `${c.firstname ?? ""} ${c.lastname ?? ""}`.trim(),
        }))
        .filter((c) =>
            filtros.value.premiacao !== "Todos"
                ? c.race === filtros.value.premiacao
                : true
        )
        .filter((c) =>
            filtros.value.categorias.length
                ? filtros.value.categorias.includes(c.category)
                : true
        )
        .filter((c) =>
            filtros.value.sexo !== "Todos" ? c.sex === filtros.value.sexo : true
        )
        .filter((c) =>
            filtros.value.equipe !== "Todos"
                ? c.team === filtros.value.equipe
                : true
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

    // Ordena por tempo
    lista.sort((a, b) => {
        const tA = a.time?.split(":").map(Number) || [99, 99, 99];
        const tB = b.time?.split(":").map(Number) || [99, 99, 99];
        const segA = tA[0] * 3600 + tA[1] * 60 + tA[2];
        const segB = tB[0] * 3600 + tB[1] * 60 + tB[2];
        return segA - segB;
    });

    // Aplica ranking geral (pós filtro)
    lista.forEach((item, index) => {
        item.rank = index + 1;
    });

    return lista;
});

// Mostra chips com filtros ativos
const filtrosAtivos = computed(() => {
    const ativos = [];

    if (filtros.value.premiacao !== "Todos")
        ativos.push(`🏆 ${filtros.value.premiacao}`);

    filtros.value.categorias.forEach((m) => ativos.push(`🏁 ${m}`));

    if (filtros.value.sexo !== "Todos")
        ativos.push(
            `⚧️ ${filtros.value.sexo === "F" ? "Feminino" : "Masculino"}`
        );

    if (filtros.value.equipe !== "Todos")
        ativos.push(`👥 ${filtros.value.equipe}`);

    if (filtros.value.nome) ativos.push(`🔍 Nome: ${filtros.value.nome}`);

    if (filtros.value.realbib) ativos.push(`#️⃣ Nº: ${filtros.value.realbib}`);

    return ativos;
});

// Detalhes do atleta
function verDetalhes(atleta) {
    router.push({
        name: "atleta",
        params: { id: atleta.bib },
        state: {
            ...atleta,
            corrida: props.corridaId,
            posicao_geral: atleta.rank_geral,
            posicao_categoria: atleta.rank_categoria,
        },
    });
}

// Resetar filtros
function limparFiltros() {
    filtros.value = {
        premiacao: "Todos",
        categorias: [],
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
.tabela-responsiva {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.v-data-table {
    min-width: 300px; /* ajuste conforme necessário */
}

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
