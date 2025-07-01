<template>
    <v-app>
        <v-container class="pt-10">
            <v-btn text @click="$router.back()">← Voltar</v-btn>

            <v-row justify="center" class="mt-2">
                <!-- Rank Geral -->
                <v-col cols="12" md="3">
                    <v-card class="theme--dark primary py-0">
                        <v-card-text
                            class="text-center text-button py-0 white--text"
                        >
                            Geral
                        </v-card-text>
                        <v-card-subtitle
                            class="text-center text-h4 pa-0 white--text"
                        >
                            <v-icon>mdi-seal</v-icon> {{ atleta.rank_geral }}°
                        </v-card-subtitle>
                    </v-card>
                </v-col>

                <!-- Rank Categoria -->
                <v-col cols="12" md="3">
                    <v-card class="theme--dark secondary py-0">
                        <v-card-text
                            class="text-center text-button py-0 white--text"
                        >
                            Categoria
                        </v-card-text>
                        <v-card-subtitle
                            class="text-center text-h4 pa-0 white--text"
                        >
                            <v-icon>mdi-star</v-icon>
                            {{ atleta.rank_categoria }}°
                        </v-card-subtitle>
                    </v-card>
                </v-col>
            </v-row>

            <v-row class="mt-0">
                <v-col>
                    <v-card class="text-center theme--dark rounded-0 pa-4">
                        <!-- Número de peito -->
                        <v-card-text class="text-h4 font-weight-bold pb-0">
                            {{ atleta.realbib }}
                        </v-card-text>

                        <!-- Nome -->
                        <v-card-text class="text-h5 primary--text py-1">
                            {{ atleta.firstname }} {{ atleta.lastname }}
                        </v-card-text>

                        <!-- Equipe -->
                        <v-card-text
                            class="text-subtitle-1 font-weight-bold grey--text"
                        >
                            Equipe: {{ atleta.team || "---" }}
                        </v-card-text>

                        <!-- Informações adicionais -->
                        <v-card-text>
                            <v-row class="text-h5 font-weight-bold">
                                <v-col cols="12" md="4" class="py-1">
                                    {{ atleta.race }}
                                </v-col>
                                <v-col cols="12" md="4" class="py-1">
                                    {{
                                        atleta.sex === "F"
                                            ? "Feminino"
                                            : "Masculino"
                                    }}
                                    |
                                    {{
                                        atleta.year
                                            ? new Date().getFullYear() -
                                              atleta.year +
                                              " Anos"
                                            : ""
                                    }}
                                </v-col>
                                <v-col cols="12" md="4" class="py-1">
                                    {{ atleta.category }}
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

            <v-row class="mt-0">
                <v-col
                    cols="6"
                    md="3"
                    v-for="(item, label) in tempos"
                    :key="label"
                >
                    <v-card class="theme--dark rounded-0 pa-2">
                        <v-card-subtitle class="text-center pb-0">{{
                            label
                        }}</v-card-subtitle>
                        <v-card-subtitle class="text-center text-h6 pt-0">
                            <v-icon v-if="item.icon" class="primary--text">{{
                                item.icon
                            }}</v-icon
                            ><br />
                            {{ item.valor || "—" }}
                        </v-card-subtitle>
                    </v-card>
                </v-col>
            </v-row>

            <v-row class="mt-4 justify-center">
                <v-col cols="auto">
                    <v-btn
                        tile
                        class="theme--dark"
                        title="Baixar PDF"
                        @click="exportarCertificado('pdf')"
                    >
                        <v-icon>mdi-download</v-icon> PDF
                    </v-btn>
                    <v-btn
                        tile
                        class="theme--dark"
                        title="Baixar Imagem"
                        @click="exportarCertificado('img')"
                    >
                        <v-icon>mdi-download</v-icon> Imagem
                    </v-btn>
                </v-col>
            </v-row>

            <!-- Certificado -->
            <div class="certificado mt-6" :style="certificadoStyle">
                <div class="conteudo">
                    <h2>CERTIFICADO DE CONCLUSÃO DO ATLETA</h2>
                    <p class="evento">
                        {{ atleta.race }} - {{ atleta.category }}
                    </p>
                    <p class="nome">
                        {{ atleta.firstname }} {{ atleta.lastname }}
                    </p>

                    <div class="dados">
                        <div><strong>Número:</strong> {{ atleta.realbib }}</div>
                        <div>
                            <strong>Modalidade:</strong> {{ atleta.race }}
                        </div>
                        <div>
                            <strong>Categoria:</strong> {{ atleta.category }}
                        </div>
                        <div>
                            <strong>Colocação Geral:</strong> {{ atleta.rank }}º
                        </div>
                        <div>
                            <strong>Tempo Bruto:</strong> {{ atleta.time }}
                        </div>
                        <div>
                            <strong>Tempo Líquido:</strong>
                            {{ atleta.chiptime }}
                        </div>
                    </div>
                </div>
            </div>
        </v-container>
    </v-app>
</template>

<script setup>
import { computed, ref, onMounted } from "vue";
import html2canvas from "html2canvas";
import jsPDF from "jspdf";
import { useRoute } from "vue-router";
import axios from "axios";
import { watch } from "vue";

const route = useRoute();

// Pegando atleta via props ou state
const props = defineProps({
    atletaId: [String, Number],
    atleta: Object,
});

const atleta = ref(history.state || props.atleta || {});


// URL do certificado dinâmico
const certificadoUrl = ref("");
const certificadoStyle = computed(() => ({
    backgroundImage: certificadoUrl.value
        ? `url('/storage/${certificadoUrl.value}')`
        : `url('/images/certificado-padrao.jpg')`, // fallback opcional
    backgroundSize: "cover",
    backgroundPosition: "center",
    backgroundRepeat: "no-repeat",
}));

watch(
    () => atleta.value,
    async (novoAtleta) => {
        if (!novoAtleta || !novoAtleta.realbib) return;

        const corridaId = atleta.value.corrida || atleta.value.corrida_id;

        if (corridaId) {
            try {
                const response = await axios.get(
                    `/api/v1/corridas/${corridaId}`
                );

                if (response.data.certificado) {
                    certificadoUrl.value = response.data.certificado;
                } else {
                    console.warn("⚠️ certificado não encontrado na corrida");
                }
            } catch (error) {
                console.error("❌ Erro ao buscar corrida:", error);
            }
        }
    },
    { immediate: true } // dispara o watch na primeira vez
);

const tempos = computed(() => {
    const tempoBruto = atleta.value.time;
    const distancia = atleta.value.race;

    return {
        "Tempo Líquido": { valor: atleta.value.chiptime, icon: "mdi-timer" },
        "Tempo Bruto": { valor: tempoBruto, icon: "mdi-timer-outline" },
        Pace: {
            valor: calcularPace(tempoBruto, distancia),
            icon: "mdi-chart-bar",
        },
        "Velocidade Média": {
            valor: calcularVelocidadeMedia(tempoBruto, distancia),
            icon: "mdi-speedometer",
        },
    };
});

// Email de suporte
const linkProblema = computed(() => {
    return `mailto:crono@chelso.com.br?subject=Problema - Evento - ${atleta.value.realbib}&body=O Atleta ${atleta.value.realbib} - ${atleta.value.firstname} ${atleta.value.lastname} está com o seguinte problema:`;
});

// Exportar certificado como imagem ou PDF
async function exportarCertificado(tipo = "pdf") {
    const element = document.querySelector(".certificado");

    if (!element) return alert("Certificado não encontrado");

    const canvas = await html2canvas(element, {
        useCORS: true,
        scale: 2,
    });

    if (tipo === "img") {
        const link = document.createElement("a");
        link.href = canvas.toDataURL("image/jpeg");
        link.download = `certificado-${atleta.value.realbib}.jpg`;
        link.click();
    } else {
        const imgData = canvas.toDataURL("image/jpeg");
        const pdf = new jsPDF("portrait", "px", [canvas.width, canvas.height]);
        pdf.addImage(imgData, "JPEG", 0, 0, canvas.width, canvas.height);
        pdf.save(`certificado-${atleta.value.realbib}.pdf`);
    }
}

function calcularPace(tempoStr, distanciaStr) {
    if (!tempoStr || !distanciaStr) return "—";

    // Extrai o número da distância (ex: "5K" => 5)
    const distanciaKm = parseFloat(distanciaStr.replace(/[^\d.]/g, ""));
    if (!distanciaKm) return "—";

    // Converte tempo HH:MM:SS em minutos
    const [hh, mm, ss] = tempoStr.split(":").map(Number);
    const tempoTotalMinutos = hh * 60 + mm + ss / 60;

    // Calcula o pace: minutos por km
    const paceMin = tempoTotalMinutos / distanciaKm;

    const min = Math.floor(paceMin);
    const sec = Math.round((paceMin - min) * 60);

    return `${String(min).padStart(2, "0")}:${String(sec).padStart(
        2,
        "0"
    )} min/km`;
}

function calcularVelocidadeMedia(tempoStr, distanciaStr) {
    if (!tempoStr || !distanciaStr) return "—";

    // Extrai o número da distância (ex: "5K" => 5)
    const distanciaKm = parseFloat(distanciaStr.replace(/[^\d.]/g, ""));
    if (!distanciaKm) return "—";

    // Converte tempo HH:MM:SS em horas
    const [hh, mm, ss] = tempoStr.split(":").map(Number);
    const tempoTotalHoras = hh + mm / 60 + ss / 3600;

    if (tempoTotalHoras === 0) return "—";

    // Calcula velocidade média
    const velocidade = distanciaKm / tempoTotalHoras;

    return `${velocidade.toFixed(2)} km/h`;
}
</script>

<style scoped>
.certificado {
    background-size: cover;
    background-position: center;
    width: 100%;
    max-width: 800px;
    height: 1125px;
    margin: 50px auto;
    position: relative;
    color: white;
    font-family: "Arial", sans-serif;
    padding: 40px;
    box-sizing: border-box;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
}
/* Removemos o fundo escuro e aplicamos sombra nos textos */
.certificado .conteudo {
    padding: 0px;
    height: 100%;
    margin-top: 300px; /* Aumente para descer mais */
    text-align: center;
}

.certificado h2,
.certificado .evento,
.certificado .nome,
.certificado .dados,
.certificado .assinaturas {
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
}

.certificado .evento {
    text-align: center;
    font-size: 18px;
    margin-bottom: 20px;
}

.certificado .nome {
    text-align: center;
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 5px;
}

.certificado .dados {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    font-size: 18px;
    margin-bottom: 10px;
    text-shadow: 4px 3px 3px rgba(0, 0, 0, 0.8); /* Para manter legível */
}

.certificado .assinaturas {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    margin-top: 50px;
}


</style>
