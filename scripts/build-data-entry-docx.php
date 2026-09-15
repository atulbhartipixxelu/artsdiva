<?php
/**
 * Builds docs/ArtsDiva-Admin-Data-Entry-Guide.docx
 */
$out = dirname(__DIR__) . '/docs/ArtsDiva-Admin-Data-Entry-Guide.docx';

$paras = [
    ['title', 'ArtsDiva Admin — Data Entry Guide'],
    ['subtitle', 'Non-technical handoff document for interns & content team'],
    ['normal', 'Login URL: https://pixxelu.com/dev/artsdiva/admin/login'],
    ['normal', 'Website: https://pixxelu.com/dev/artsdiva'],
    ['heading1', '1. Login & Basic Rules'],
    ['bullet', 'Open the login URL and enter email + password given by admin.'],
    ['bullet', 'Left sidebar shows all sections you can manage.'],
    ['bullet', 'Active / Published = shows on public website. Inactive = hidden but still saved.'],
    ['bullet', 'Always click Save after filling a form.'],
    ['bullet', 'Images: JPG / PNG / WebP preferred; keep files under about 2–5 MB.'],
    ['important', 'Correct order: FIRST create Artist, THEN create Artwork and select that artist.'],
    ['heading1', '2. Dashboard Menu — What Each Item Is For'],
    ['bullet', 'Artworks — Paintings / works (title, serial, image, price). Shows on Catalogue.'],
    ['bullet', 'Artists — Artist profile (name, bio, photo). Shows on Artists page + artwork credit.'],
    ['bullet', 'Hero Slides — Home page big banner images + buttons.'],
    ['bullet', 'Exhibitions — Exhibition cards on Exhibitions page.'],
    ['bullet', 'Events — Event cards on Events page.'],
    ['bullet', 'News — News articles on News page.'],
    ['bullet', 'Publications — Books / press cards on Publications page.'],
    ['bullet', 'Pages — About / Leasing / Contact page text (edit only).'],
    ['bullet', 'Inquiries — Visitor form messages (view only — no upload).'],
    ['bullet', 'Admins — Staff login accounts (superadmin only).'],
    ['heading1', '3. How to Upload an Artist'],
    ['normal', 'Step 1: Sidebar → Artists → Add Artist'],
    ['normal', 'Step 2: Fill these fields:'],
    ['bullet', 'Name * — Full artist name (e.g. Frida Kahlo)'],
    ['bullet', 'Slug — Leave blank (system can create it)'],
    ['bullet', 'City / Country — Optional location'],
    ['bullet', 'Bio — Short artist biography'],
    ['bullet', 'Image — Artist photo / portrait (recommended)'],
    ['bullet', 'Sort order — Number for display order (0 = default)'],
    ['bullet', 'Published — Tick if ready to show on website'],
    ['bullet', 'Featured — Optional highlight'],
    ['normal', 'Step 3: Click Save'],
    ['normal', 'Step 4: Confirm artist appears in list as Active'],
    ['heading1', '4. How to Upload an Artwork'],
    ['important', 'Do this only after the artist already exists in Artists.'],
    ['normal', 'Step 1: Sidebar → Artworks → Add Artwork'],
    ['normal', 'Step 2: Fill these fields:'],
    ['bullet', 'Title * — Artwork name'],
    ['bullet', 'Serial number * — Unique ID like 0001, 0010 — never reuse'],
    ['bullet', 'Slug — Leave blank unless instructed'],
    ['bullet', 'Artist — Select from dropdown'],
    ['bullet', 'Category — e.g. Painting, Print'],
    ['bullet', 'City — Optional'],
    ['bullet', 'Price (EUR) * — Number only; use 0 if not for sale'],
    ['bullet', 'Dimensions / Weight / Year / Medium — Optional details'],
    ['bullet', 'Description — Full text for detail page'],
    ['bullet', 'Thumbnail — Main catalogue card image (recommended)'],
    ['bullet', 'Gallery images — Extra detail photos (multiple allowed)'],
    ['bullet', 'Sort order — Display order'],
    ['bullet', 'Published — Tick to show on catalogue'],
    ['bullet', 'Featured — Optional home / featured display'],
    ['normal', 'Step 3: Click Save'],
    ['normal', 'Step 4: Open View Website → Catalogue and search by serial or title'],
    ['heading2', 'Serial number rules'],
    ['bullet', 'Must be unique for every artwork'],
    ['bullet', 'Prefer 4-digit style: 0001, 0002, …'],
    ['bullet', 'Used for inventory tracking and website search'],
    ['heading2', 'Image checklist before upload'],
    ['bullet', 'Correct artwork (not wrong painting / wrong edition)'],
    ['bullet', 'Clear, high quality'],
    ['bullet', 'Correct orientation (not sideways)'],
    ['bullet', 'Thumbnail = main face of the work'],
    ['heading1', '5. Other Content Upload Fields'],
    ['heading2', 'Hero Slides'],
    ['bullet', 'Eyebrow, Title *, Subtitle, Button 1/2 labels & URLs, Image, Published'],
    ['bullet', 'URL tip: write path only (catalogue), not full website URL'],
    ['heading2', 'Exhibitions'],
    ['bullet', 'Title *, Slug, Subtitle, Dates, Location, Description, Image, Sort order, Published'],
    ['heading2', 'Events'],
    ['bullet', 'Title *, Slug, Tags (comma separated), Date label, Time label, Location, Description, Image, Sort order, Published'],
    ['heading2', 'News'],
    ['bullet', 'Title *, Slug, Published at, Image, Excerpt, Body, Published'],
    ['heading2', 'Publications'],
    ['bullet', 'Artist name *, Title *, Slug, Link URL, Excerpt, Image, Sort order, Published'],
    ['heading2', 'Pages (About / Leasing / Contact)'],
    ['bullet', 'Title *, Subtitle, Body (HTML allowed), CTA label/URL, Meta description, Image, Published'],
    ['bullet', 'Slug is fixed — do not change'],
    ['heading1', '6. Daily Checklist for Interns'],
    ['bullet', 'Artist exists before artwork'],
    ['bullet', 'Serial number unique and correct'],
    ['bullet', 'Correct image attached (double-check client file name)'],
    ['bullet', 'Title + description match client brief'],
    ['bullet', 'Artist selected in artwork form'],
    ['bullet', 'Published / Active turned on when ready'],
    ['bullet', 'After save, check Catalogue page on website'],
    ['bullet', 'If wrong → turn Inactive immediately, then edit and fix'],
    ['heading1', '7. Quick Troubleshooting'],
    ['bullet', 'Artwork not on website → Check Active/Published; refresh browser'],
    ['bullet', 'Artist missing in dropdown → Create artist first, reopen artwork form'],
    ['bullet', 'Serial already taken → Choose a new unused serial'],
    ['bullet', 'Wrong image → Edit artwork → upload new Thumbnail → Save'],
    ['bullet', 'Hero button wrong page → Use short path like catalogue, not full domain'],
    ['heading1', '8. Hindi Quick Summary (तेज़ गाइड)'],
    ['normal', 'Login: admin/login पर जाकर email + password डालें।'],
    ['normal', 'Pehle Artists → Add Artist → Name, Bio, Photo → Published → Save।'],
    ['normal', 'Phir Artworks → Add Artwork → Title, Serial, Artist select, Price, Thumbnail → Published → Save।'],
    ['normal', 'Website Catalogue pe check karein. Galat ho to Inactive kar ke edit karein।'],
    ['normal', 'Hero / Exhibitions / Events / News / Publications / Pages bhi sidebar se same tarah Add → Fill → Save।'],
    ['normal', 'Inquiries sirf messages dekhne ke liye hain — upload nahi।'],
    ['normal', '— End of document —'],
];

function esc(string $s): string
{
    return htmlspecialchars($s, ENT_XML1 | ENT_QUOTES, 'UTF-8');
}

function p(string $text, string $style = 'Normal'): string
{
    return '<w:p><w:pPr><w:pStyle w:val="' . esc($style) . '"/></w:pPr><w:r><w:t xml:space="preserve">' . esc($text) . '</w:t></w:r></w:p>';
}

$body = '';
foreach ($paras as [$type, $text]) {
    $style = match ($type) {
        'title' => 'Title',
        'subtitle' => 'Subtitle',
        'heading1' => 'Heading1',
        'heading2' => 'Heading2',
        'bullet' => 'ListParagraph',
        'important' => 'IntenseQuote',
        default => 'Normal',
    };
    if ($type === 'bullet') {
        $body .= '<w:p><w:pPr><w:pStyle w:val="ListParagraph"/><w:numPr><w:ilvl w:val="0"/><w:numId w:val="1"/></w:numPr></w:pPr><w:r><w:t xml:space="preserve">' . esc($text) . '</w:t></w:r></w:p>';
    } else {
        $body .= p($text, $style);
    }
}

$documentXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:body>
    ' . $body . '
    <w:sectPr>
      <w:pgSz w:w="12240" w:h="15840"/>
      <w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440"/>
    </w:sectPr>
  </w:body>
</w:document>';

$stylesXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:style w:type="paragraph" w:styleId="Normal" w:default="1"><w:name w:val="Normal"/><w:rPr><w:sz w:val="22"/><w:szCs w:val="22"/><w:rFonts w:ascii="Calibri" w:hAnsi="Calibri"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Title"><w:name w:val="Title"/><w:basedOn w:val="Normal"/><w:rPr><w:b/><w:sz w:val="40"/><w:szCs w:val="40"/><w:color w:val="1F4E79"/></w:rPr><w:pPr><w:spacing w:after="120"/></w:pPr></w:style>
  <w:style w:type="paragraph" w:styleId="Subtitle"><w:name w:val="Subtitle"/><w:basedOn w:val="Normal"/><w:rPr><w:i/><w:sz w:val="24"/><w:color w:val="595959"/></w:rPr><w:pPr><w:spacing w:after="240"/></w:pPr></w:style>
  <w:style w:type="paragraph" w:styleId="Heading1"><w:name w:val="heading 1"/><w:basedOn w:val="Normal"/><w:rPr><w:b/><w:sz w:val="28"/><w:color w:val="2E75B6"/></w:rPr><w:pPr><w:spacing w:before="360" w:after="120"/></w:pPr></w:style>
  <w:style w:type="paragraph" w:styleId="Heading2"><w:name w:val="heading 2"/><w:basedOn w:val="Normal"/><w:rPr><w:b/><w:sz w:val="24"/><w:color w:val="5B9BD5"/></w:rPr><w:pPr><w:spacing w:before="240" w:after="80"/></w:pPr></w:style>
  <w:style w:type="paragraph" w:styleId="ListParagraph"><w:name w:val="List Paragraph"/><w:basedOn w:val="Normal"/><w:pPr><w:ind w:left="720"/><w:spacing w:after="60"/></w:pPr></w:style>
  <w:style w:type="paragraph" w:styleId="IntenseQuote"><w:name w:val="Intense Quote"/><w:basedOn w:val="Normal"/><w:rPr><w:b/><w:color w:val="C00000"/></w:rPr><w:pPr><w:spacing w:before="120" w:after="120"/><w:ind w:left="360"/></w:pPr></w:style>
</w:styles>';

$numberingXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:numbering xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:abstractNum w:abstractNumId="0">
    <w:multiLevelType w:val="hybridMultilevel"/>
    <w:lvl w:ilvl="0"><w:start w:val="1"/><w:numFmt w:val="bullet"/><w:lvlText w:val="•"/><w:lvlJc w:val="left"/><w:pPr><w:ind w:left="720" w:hanging="360"/></w:pPr></w:lvl>
  </w:abstractNum>
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
    fwrite(STDERR, "Failed to create docx\n");
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
echo 'Size: ' . filesize($out) . " bytes\n";
