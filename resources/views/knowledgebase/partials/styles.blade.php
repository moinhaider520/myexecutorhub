<style>
    .knowledgebase-shell .container {
        max-width: 1280px;
    }

    .knowledgebase-shell .knowledgebase-card {
        padding: clamp(24px, 2.4vw, 40px) !important;
        border: 1px solid #edf2f7;
        border-radius: 28px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .knowledgebase-shell .knowledgebase-card > h2:first-of-type,
    .knowledgebase-shell .knowledgebase-card .p-2:first-child {
        margin-bottom: 1.25rem !important;
    }

    .knowledgebase-shell .knowledgebase-card h2 {
        color: #243b53;
        font-size: clamp(2rem, 2.1vw, 2.75rem);
        line-height: 1.15;
        letter-spacing: -0.02em;
        margin-bottom: 1rem !important;
    }

    .knowledgebase-shell .knowledgebase-card h2:not(:first-of-type) {
        margin-top: 2.5rem;
        padding-top: 1.75rem;
        border-top: 1px solid #edf2f7;
    }

    .knowledgebase-shell .knowledgebase-card p,
    .knowledgebase-shell .knowledgebase-card li {
        color: #334e68;
        font-size: 1.05rem;
        line-height: 1.9;
    }

    .knowledgebase-shell .knowledgebase-card p {
        margin-bottom: 1rem;
        max-width: 1050px;
    }

    .knowledgebase-shell .knowledgebase-card ol,
    .knowledgebase-shell .knowledgebase-card ul {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .knowledgebase-shell .knowledgebase-card li + li {
        margin-top: 0.45rem;
    }

    .knowledgebase-shell .knowledgebase-card img {
        border-radius: 18px;
    }

    .knowledgebase-shell .knowledgebase-card .btn {
        border-radius: 999px;
        padding-left: 1.2rem;
        padding-right: 1.2rem;
    }

    @media (max-width: 767.98px) {
        .knowledgebase-shell .knowledgebase-card {
            border-radius: 22px;
        }

        .knowledgebase-shell .knowledgebase-card h2 {
            font-size: 1.8rem;
        }
    }
</style>
