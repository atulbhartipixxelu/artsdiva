<?php
/**
 * Build docs/Deep-Scope-Confirmation.docx — client reply + deliverables list
 */
$out = dirname(__DIR__) . '/docs/Deep-Scope-Confirmation.docx';

$paras = [
    ['title', 'ArtsDiva — Scope Confirmation (Reply to Deep)'],
    ['subtitle', 'Ready-to-send client message + deliverables checklist'],
    ['heading1', 'Email / Message (copy-paste to Deep)'],
    ['normal', 'Hello Deep,'],
    ['normal', 'Thank you for clarifying. I understand the scope clearly, and I confirm it as follows.'],
    ['heading2', 'What you need from me now'],
    ['bullet', 'Artwork master list — every artwork already in the database with serial number, artist name, title, and description, for intern handoff after the masters are finished.'],
    ['bullet', 'Proper system documentation covering front end and back end, in two parts: (1) technical architecture for a future developer, and (2) data entry process for someone with no coding background.'],
    ['heading2', 'Remaining scope (no further technical development beyond this)'],
    ['bullet', '1. Documentation, as described above.'],
    ['bullet', '2. Port the complete ArtsDiva code to the new Hostinger server, and get the ArtsDiva domain live. Waiting until you confirm the new server is purchased/ready.'],
    ['bullet', '3. Port all your other websites — ODI, Fantasia Travels, AAA, and the rest — to the same new Hostinger server.'],
    ['important', 'Once these three items are done, my part of this project is complete. There is no further technical development work beyond this scope.'],
    ['normal', 'I will share the artwork master list and the documentation files (developer architecture + intern data-entry guide). Please confirm when the new Hostinger server is ready so we can proceed with the ports and go-live.'],
    ['normal', 'Best regards,'],
    ['normal', 'Rakesh'],
    ['heading1', 'Deliverables checklist (attachments)'],
    ['bullet', 'Artwork master list (Markdown) — docs/ARTWORK-MASTER-LIST.md'],
    ['bullet', 'Artwork master list (CSV / Excel-friendly) — docs/ARTWORK-MASTER-LIST.csv'],
    ['bullet', 'Technical architecture (developers) — docs/TECHNICAL-ARCHITECTURE.md'],
    ['bullet', 'Data entry guide (non-coders, Markdown) — docs/DATA-ENTRY-GUIDE.md'],
    ['bullet', 'Data entry guide (Word) — docs/ArtsDiva-Admin-Data-Entry-Guide.docx'],
    ['bullet', 'This confirmation document — docs/Deep-Scope-Confirmation.docx'],
    ['heading1', 'Scope list — understood and agreed'],
    ['bullet', 'Documentation only for system understanding and correct data entry — not new features.'],
    ['bullet', 'ArtsDiva full port + ArtsDiva domain live on the new Hostinger server (when provided).'],
    ['bullet', 'Port ODI, Fantasia Travels, AAA, and remaining sites to that same new server.'],
    ['bullet', 'After items 1–3: project complete for Rakesh’s side.'],
    ['bullet', 'No additional technical development beyond this remaining scope.'],
    ['heading1', 'Waiting on client'],
    ['bullet', 'Purchase / access details for the new Hostinger server'],
    ['bullet', 'Confirmation that ArtsDiva domain DNS/pointing is ready for go-live'],
    ['bullet', 'Access notes for other sites to port (ODI, Fantasia Travels, AAA, etc.) if not already shared'],
    ['normal', '— End of document —'],
];

function esc(string $s): string
{
    return htmlspecialchars($s, ENT_XML1 | ENT_QUOTES, 'UTF-8');
}

$body = '';
foreach ($paras as [$type, $text]) {
    if ($type === 'bullet') {
        $body .= '<w:p><w:pPr><w:pStyle w:val="ListParagraph"/><w:numPr><w:ilvl w:val="0"/><w:numId w:val="1"/></w:numPr></w:pPr><w:r><w:t xml:space="preserve">' . esc($text) . '</w:t></w:r></w:p>';
        continue;
    }
    $style = match ($type) {
        'title' => 'Title',
        'subtitle' => 'Subtitle',
        'heading1' => 'Heading1',
        'heading2' => 'Heading2',
        'important' => 'IntenseQuote',
        default => 'Normal',
    };
    $body .= '<w:p><w:pPr><w:pStyle w:val="' . esc($style) . '"/></w:pPr><w:r><w:t xml:space="preserve">' . esc($text) . '</w:t></w:r></w:p>';
}

$documentXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:body>'.$body.'<w:sectPr><w:pgSz w:w="12240" w:h="15840"/><w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440"/></w:sectPr></w:body>
</w:document>';

$stylesXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:style w:type="paragraph" w:styleId="Normal" w:default="1"><w:name w:val="Normal"/><w:rPr><w:sz w:val="22"/><w:szCs w:val="22"/><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Title"><w:name w:val="Title"/><w:basedOn w:val="Normal"/><w:rPr><w:b/><w:sz w:val="36"/><w:color w:val="1F4E79"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Subtitle"><w:name w:val="Subtitle"/><w:basedOn w:val="Normal"/><w:rPr><w:i/><w:sz w:val="22"/><w:color w:val="595959"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Heading1"><w:name w:val="heading 1"/><w:basedOn w:val="Normal"/><w:rPr><w:b/><w:sz w:val="28"/><w:color w:val="2E75B6"/></w:rPr><w:pPr><w:spacing w:before="360" w:after="120"/></w:pPr></w:style>
  <w:style w:type="paragraph" w:styleId="Heading2"><w:name w:val="heading 2"/><w:basedOn w:val="Normal"/><w:rPr><w:b/><w:sz w:val="24"/><w:color w:val="5B9BD5"/></w:rPr><w:pPr><w:spacing w:before="240" w:after="80"/></w:pPr></w:style>
  <w:style w:type="paragraph" w:styleId="ListParagraph"><w:name w:val="List Paragraph"/><w:basedOn w:val="Normal"/><w:pPr><w:ind w:left="720"/><w:spacing w:after="60"/></w:pPr></w:style>
  <w:style w:type="paragraph" w:styleId="IntenseQuote"><w:name w:val="Intense Quote"/><w:basedOn w:val="Normal"/><w:rPr><w:b/><w:color w:val="C00000"/></w:rPr><w:pPr><w:spacing w:before="120" w:after="120"/><w:ind w:left="360"/></w:pPr></w:style>
</w:styles>';

$numberingXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:numbering xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:abstractNum w:abstractNumId="0"><w:multiLevelType w:val="hybridMultilevel"/><w:lvl w:ilvl="0"><w:start w:val="1"/><w:numFmt w:val="bullet"/><w:lvlText w:val="•"/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="720" w:hanging="360"/></w:pPr></w:lvl></w:abstractNum>
  <w:num w:numId="1"><w:abstractNumId w:val="0"/></w:num>
</w:numbering>';

$contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
  <Override PartName="/word/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"/>
  <Override PartName="/word/numbering.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.numbering+xml"/>
</Types>';

$rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
</Relationships>';

$docRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/numbering" Target="numbering.xml"/>
</Relationships>';

if (file_exists($out)) {
    unlink($out);
}
$zip = new ZipArchive();
if ($zip->open($out, ZipArchive::CREATE) !== true) {
    fwrite(STDERR, "Failed\n");
    exit(1);
}
$zip->addFromString('[Content_Types].xml', $contentTypes);
$zip->addFromString('_rels/.rels', $rels);
$zip->addFromString('word/document.xml', $documentXml);
$zip->addFromString('word/styles.xml', $stylesXml);
$zip->addFromString('word/numbering.xml', $numberingXml);
$zip->addFromString('word/_rels/document.xml.rels', $docRels);
$zip->close();
echo "Created: {$out}\n";
