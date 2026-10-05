<?php

namespace App\Exports;

use App\Models\ContactUs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ContactUsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $dateStart;
    protected $dateEnd;

    public function __construct($dateStart = null, $dateEnd = null)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }

    public function collection()
    {
        $query = ContactUs::query();

        if ($this->dateStart && $this->dateEnd) {
            $query->whereBetween('created_at', [
                $this->dateStart . ' 00:00:00',
                $this->dateEnd . ' 23:59:59'
            ]);
        } elseif ($this->dateStart) {
            $query->whereDate('created_at', '>=', $this->dateStart);
        } elseif ($this->dateEnd) {
            $query->whereDate('created_at', '<=', $this->dateEnd);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            // We'll leave data headings (row 2), as row 1 will be the custom big header
            'No',
            'Nama Lengkap',
            'Email',
            'Nomor Handphone',
            'Nama Perusahaan',
            'Lokasi Perusahaan',
            'Produk/Jasa',
            'Pesan',
            'Dikirim Pada'
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        // Batasi pesan maksimal 80 karakter per baris dengan "\n" agar wrap text otomatis enter ke bawah di Excel.
        $pesan = $row->Pesan ?? '-';
        $pesan = wordwrap($pesan, 80, "\n", true);

        return [
            $no,
            $row->NamaLengkap,
            $row->Email,
            $row->NomorHandphone ?? '-',
            $row->CompanyName ?? '-',
            $row->LokasiPerusahaan ?? '-',
            $row->ProdukYangDibutuhkan ?? '-',
            $pesan,
            $row->created_at ? $row->created_at->format('d-m-Y H:i') : '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // === TAMPILKAN PROFESIONAL HEADER UTAMA DI ATAS (ROW 1) ===
        $sheet->insertNewRowBefore(1, 1);
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', '📥 Rekapitulasi Kotak Masuk — Data Formulir Contact Us');

        // Style for professional/pretty main header (row 1)
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '1a1a1a'],
                'size' => 16,
                'name' => 'Calibri',
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center'
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'DAF0FF'],
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(32);

        // === HEADINGS STYLE (ROW 2) ===
        $sheet->getStyle('A2:I2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '007BFF']
            ],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'top']
        ]);
        $sheet->getRowDimension(2)->setRowHeight(26);

        // Auto-size columns (except Pesan/h, force width for Pesan column to limit text visually)
        foreach (range('A', 'I') as $col) {
            if ($col == 'H') {
                // Pesan/Message column, limit width (e.g. ~60 chars is 38-45pt)
                $sheet->getColumnDimension($col)->setWidth(45);
            } else {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        // Wrap text for message column
        $sheet->getStyle('H')->getAlignment()->setWrapText(true);

        // Set vertical align top for all data cells
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A3:I{$lastRow}")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

        // Borders for data cells (all cells containing headers + content)
        $sheet->getStyle("A2:I{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ]
        ]);

        // Tambahkan professional bottom margin (optional – can leave empty row)
        // $sheet->insertNewRowBefore($lastRow + 1, 1);

        return [];
    }
}
