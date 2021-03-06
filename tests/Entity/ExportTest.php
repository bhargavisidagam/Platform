<?php

namespace Tests;

use DocsPen\Chapter;
use DocsPen\Page;

class ExportTest extends TestCase
{
    public function test_page_text_export()
    {
        $page = Page::first();
        $this->asEditor();

        $resp = $this->get($page->getUrl('/export/plaintext'));
        $resp->assertStatus(200);
        $resp->assertSee($page->name);
        $resp->assertHeader('Content-Disposition', 'attachment; filename="'.$page->slug.'.txt');
    }

    public function test_page_pdf_export()
    {
        $page = Page::first();
        $this->asEditor();

        $resp = $this->get($page->getUrl('/export/pdf'));
        $resp->assertStatus(200);
        $resp->assertHeader('Content-Disposition', 'attachment; filename="'.$page->slug.'.pdf');
    }

    public function test_page_html_export()
    {
        $page = Page::first();
        $this->asEditor();

        $resp = $this->get($page->getUrl('/export/html'));
        $resp->assertStatus(200);
        $resp->assertSee($page->name);
        $resp->assertHeader('Content-Disposition', 'attachment; filename="'.$page->slug.'.html');
    }

    public function test_book_text_export()
    {
        $page = Page::first();
        $book = $page->book;
        $this->asEditor();

        $resp = $this->get($book->getUrl('/export/plaintext'));
        $resp->assertStatus(200);
        $resp->assertSee($book->name);
        $resp->assertSee($page->name);
        $resp->assertHeader('Content-Disposition', 'attachment; filename="'.$book->slug.'.txt');
    }

    public function test_book_pdf_export()
    {
        $page = Page::first();
        $book = $page->book;
        $this->asEditor();

        $resp = $this->get($book->getUrl('/export/pdf'));
        $resp->assertStatus(200);
        $resp->assertHeader('Content-Disposition', 'attachment; filename="'.$book->slug.'.pdf');
    }

    public function test_book_html_export()
    {
        $page = Page::first();
        $book = $page->book;
        $this->asEditor();

        $resp = $this->get($book->getUrl('/export/html'));
        $resp->assertStatus(200);
        $resp->assertSee($book->name);
        $resp->assertSee($page->name);
        $resp->assertHeader('Content-Disposition', 'attachment; filename="'.$book->slug.'.html');
    }

    public function test_chapter_text_export()
    {
        $chapter = Chapter::first();
        $page = $chapter->pages[0];
        $this->asEditor();

        $resp = $this->get($chapter->getUrl('/export/plaintext'));
        $resp->assertStatus(200);
        $resp->assertSee($chapter->name);
        $resp->assertSee($page->name);
        $resp->assertHeader('Content-Disposition', 'attachment; filename="'.$chapter->slug.'.txt');
    }

    public function test_chapter_pdf_export()
    {
        $chapter = Chapter::first();
        $this->asEditor();

        $resp = $this->get($chapter->getUrl('/export/pdf'));
        $resp->assertStatus(200);
        $resp->assertHeader('Content-Disposition', 'attachment; filename="'.$chapter->slug.'.pdf');
    }

    public function test_chapter_html_export()
    {
        $chapter = Chapter::first();
        $page = $chapter->pages[0];
        $this->asEditor();

        $resp = $this->get($chapter->getUrl('/export/html'));
        $resp->assertStatus(200);
        $resp->assertSee($chapter->name);
        $resp->assertSee($page->name);
        $resp->assertHeader('Content-Disposition', 'attachment; filename="'.$chapter->slug.'.html');
    }
}
