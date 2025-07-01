import {
    createRouter,
    createWebHistory
} from 'vue-router';
import Eventos from './components/Eventos.vue'; // <-- Importa o novo componente principal
import RankingTable from './components/RankingTable.vue';
import AtletaDetalhe from './components/AtletaDetalhe.vue';
import CorridaEdit from './components/CorridaEdit.vue';
import CadastrarCorrida from './components/cadastrar.vue';

const routes = [{
        path: '/cadastrar-corrida',
        name: 'CadastrarCorrida',
        component: CadastrarCorrida,
    }, {
        path: '/corridas/edit/:id',
        name: 'editar-corrida',
        component: CorridaEdit,
        props: true
    },
    {
        path: '/corridas/:id',
        name: 'corridaDetalhe',
        component: RankingTable,
        props: route => ({
            corridaId: route.params.id
        }) // Passa o ID como prop
    },
    {
        path: '/',
        name: 'eventos',
        component: Eventos // <-- Mostra Eventos.vue como a página inicial
    },
    {
        path: '/ranking',
        name: 'ranking',
        component: RankingTable,
        props: () => ({
            corredores: window.corredoresData
        }) // ainda usa os dados vindos do blade
    },
    {
        path: '/atleta/:id',
        name: 'atleta',
        component: AtletaDetalhe,
        props: route => ({
            atletaId: route.params.id,
            atleta: history.state || {} // <-- útil para navegar com dados já carregados
        })
    },
    {
        path: '/resultados/:id',
        redirect: '/ranking' // redireciona para a rota /ranking
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/' // fallback para rotas inexistentes
    },
    {
        path: '/edit/:id',
        name: 'corrida-edit',
        component: CorridaEdit
    }

];

export default createRouter({
    history: createWebHistory(),
    routes
});
