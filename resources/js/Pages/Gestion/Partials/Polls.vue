<script setup>
import { ref } from "vue";
import { dialogBreakpoints } from "@/utils/helpers";
import PollList from "./Polls/PollList.vue";
import Stats from "./Polls/Stats.vue";
import PollForm from "./Polls/PollForm.vue";
import CreatePanel from "@/Components/Gestion/CreatePanel.vue";

const showStats = ref(false);
</script>

<template>
    <div class="">
        <Dialog
            v-model:visible="showStats"
            modal
            header="Statistiques des sondages"
            :style="{ width: '50rem' }"
            :breakpoints="dialogBreakpoints"
        >
            <Stats />
        </Dialog>
        <CreatePanel
            title="Sondages"
            description="Créer et gérer les differents sondages."
            btn-text="Créer un Sondage"
            image="/gestion/images/vote.png"
            :create-component="PollForm"
        >
            <div class="flex justify-center">
                <Button
                    label="Statistiques"
                    @click="showStats = true"
                    severity="secondary"
                    size="small"
                    raised
                />
            </div>
        </CreatePanel>
        <Divider />
        <PollList
            :data="$page.props.polls.list"
            :filter-name="$page.props.polls.filter_name"
        />
    </div>
</template>
