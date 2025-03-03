<template>
    <div class="cv-container">
        <div class="form-section">
            <h2>Créer ton CV</h2>
            <div class="p-fluid">
                <!-- Nom -->
                <FloatLabel>
                    <InputText id="name" v-model="form.name" />
                    <label for="name">Nom & Prénom</label>
                </FloatLabel>

                <!-- Email -->
                <FloatLabel>
                    <InputText id="email" v-model="form.email" />
                    <label for="email">Email</label>
                </FloatLabel>

                <!-- Téléphone -->
                <FloatLabel>
                    <InputText id="phone" v-model="form.phone" />
                    <label for="phone">Téléphone</label>
                </FloatLabel>

                <!-- Objectif professionnel -->
                <FloatLabel>
                    <Textarea id="objectif" v-model="form.objectif" rows="3" />
                    <label for="objectif">Objectif Professionnel</label>
                </FloatLabel>

                <!-- Expérience -->
                <FloatLabel>
                    <Textarea
                        id="experience"
                        v-model="form.experience"
                        rows="4"
                    />
                    <label for="experience">Expérience Professionnelle</label>
                </FloatLabel>

                <!-- Formation -->
                <FloatLabel>
                    <Textarea
                        id="formation"
                        v-model="form.formation"
                        rows="3"
                    />
                    <label for="formation">Formation</label>
                </FloatLabel>

                <!-- Compétences -->
                <FloatLabel>
                    <Textarea id="skills" v-model="form.skills" rows="3" />
                    <label for="skills">Compétences</label>
                </FloatLabel>

                <!-- Bouton -->
                <Button
                    label="Générer CV PDF"
                    icon="pi pi-file-pdf"
                    @click="generatePDF"
                />
            </div>
        </div>

        <!-- Aperçu -->
        <div class="preview-section">
            <h2>Aperçu</h2>
            <div class="cv-preview">
                <h3>{{ form.name }}</h3>
                <p><strong>Email :</strong> {{ form.email }}</p>
                <p><strong>Téléphone :</strong> {{ form.phone }}</p>
                <p><strong>Objectif :</strong> {{ form.objectif }}</p>
                <p><strong>Expérience :</strong> {{ form.experience }}</p>
                <p><strong>Formation :</strong> {{ form.formation }}</p>
                <p><strong>Compétences :</strong> {{ form.skills }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import jsPDF from "jspdf";

const form = useForm({
    name: "",
    email: "",
    phone: "",
    objectif: "",
    experience: "",
    formation: "",
    skills: "",
});

const generatePDF = () => {
    const doc = new jsPDF();
    doc.text(`Nom: ${form.name}`, 10, 10);
    doc.text(`Email: ${form.email}`, 10, 20);
    doc.text(`Téléphone: ${form.phone}`, 10, 30);
    doc.text(`Objectif: ${form.objectif}`, 10, 40);
    doc.text(`Expérience: ${form.experience}`, 10, 50);
    doc.text(`Formation: ${form.formation}`, 10, 60);
    doc.text(`Compétences: ${form.skills}`, 10, 70);
    doc.save("CV.pdf");
};
</script>

<style scoped>
.cv-container {
    display: flex;
    gap: 2rem;
    padding: 2rem;
}

.form-section,
.preview-section {
    width: 50%;
}

.cv-preview {
    border: 1px solid #ddd;
    padding: 1rem;
    border-radius: 5px;
    background: #f9f9f9;
}

.p-fluid > * {
    margin-bottom: 1rem;
}
</style>
