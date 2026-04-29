<style>
    @page {
        size: A4;
        margin: 10mm 13mm 9mm;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        background: #f3f4f6;
        color: #000;
        font-family: "Times New Roman", Times, serif;
        font-size: 10.5pt;
        line-height: 1.15;
    }

    .print-toolbar {
        width: 210mm;
        margin: 16px auto;
        display: flex;
        justify-content: space-between;
        gap: 12px;
        font-family: Arial, sans-serif;
    }

    .print-toolbar a,
    .print-toolbar button {
        border: 0;
        border-radius: 4px;
        padding: 9px 16px;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .print-toolbar a {
        background: #6b7280;
    }

    .print-toolbar button {
        background: #047857;
    }

    .sheet {
        width: 210mm;
        min-height: 297mm;
        margin: 0 auto 6mm;
        padding: 10mm 13mm 9mm;
        background: #fff;
        page-break-after: always;
        box-shadow: none;
        position: relative;
        overflow: visible;
    }

    .sheet:last-child {
        page-break-after: auto;
    }

    .brand-header {
        display: grid;
        grid-template-columns: 28mm 1fr 24mm;
        align-items: center;
        gap: 5mm;
        margin-bottom: 3mm;
    }

    .brand-header img {
        width: 24mm;
        height: 24mm;
        object-fit: contain;
    }

    .brand-title {
        text-align: center;
        font-weight: 700;
        font-size: 13pt;
        letter-spacing: 0;
        text-transform: uppercase;
    }

    .brand-title span {
        display: block;
        font-size: 12pt;
        margin-top: 1mm;
    }

    .form-code {
        align-self: end;
        text-align: right;
        font-size: 8.5pt;
    }

    .form-title {
        text-align: center;
        font-weight: 700;
        font-size: 14pt;
        text-decoration: underline;
        margin: 2mm 0 4mm;
    }

    .guide {
        font-size: 9.5pt;
        margin: 0 0 3mm 0;
    }

    .section-title {
        font-weight: 700;
        margin: 2.4mm 0 1.2mm;
        text-transform: uppercase;
        break-after: avoid;
        page-break-after: avoid;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        break-inside: avoid;
        page-break-inside: avoid;
    }

    .form-table td,
    .form-table th {
        border: 1px solid #000;
        padding: 1.2mm 1.6mm;
        vertical-align: top;
    }

    .form-table th {
        text-align: center;
        font-weight: 700;
    }

    .compact td,
    .compact th {
        padding: .85mm 1.4mm;
    }

    .label {
        width: 39mm;
        white-space: nowrap;
    }

    .colon {
        width: 3mm;
        text-align: center;
    }

    .value {
        min-height: 6mm;
        white-space: normal;
    }

    .choice {
        display: inline-block;
        margin-right: 4mm;
        white-space: nowrap;
    }

    .choice-mark {
        display: inline-block;
        width: 4mm;
        text-align: center;
        font-weight: 700;
    }

    .line-box {
        border: 1px solid #000;
        min-height: 17mm;
        padding: 1.5mm 2mm;
        white-space: pre-line;
        break-inside: avoid;
        page-break-inside: avoid;
    }

    .large-box {
        min-height: 30mm;
    }

    .signature-row {
        display: grid;
        grid-template-columns: 1fr 52mm;
        gap: 10mm;
        margin-top: 8mm;
    }

    .signature-box {
        text-align: center;
    }

    .signature-space {
        height: 22mm;
    }

    .muted-note {
        font-size: 9pt;
        font-style: italic;
        break-after: avoid;
        page-break-after: avoid;
    }

    .struktur-organisasi-content img {
        max-width: 100% !important;
        height: auto !important;
        display: block;
        margin: 2mm 0;
    }

    .quill-print-content {
        overflow: visible;
    }

    .quill-print-content p,
    .quill-print-content ol,
    .quill-print-content ul {
        margin: 0 0 1.5mm;
    }

    .quill-print-content ol,
    .quill-print-content ul {
        padding-left: 7mm;
    }

    .quill-print-content .ql-align-center {
        text-align: center;
    }

    .quill-print-content .ql-align-right {
        text-align: right;
    }

    .quill-print-content .ql-align-justify {
        text-align: justify;
    }

    .quill-print-content .ql-indent-1 {
        padding-left: 7mm;
    }

    .quill-print-content .ql-indent-2 {
        padding-left: 14mm;
    }

    .quill-print-content .ql-indent-3 {
        padding-left: 21mm;
    }

    .avoid-break {
        break-inside: avoid;
        page-break-inside: avoid;
    }

    p {
        margin: 2mm 0;
    }

    @media print {
        body {
            background: #fff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .print-toolbar {
            display: none !important;
        }

        .sheet {
            width: auto;
            min-height: auto;
            margin: 0;
            padding: 0;
            box-shadow: none;
            overflow: visible;
        }
    }
</style>
