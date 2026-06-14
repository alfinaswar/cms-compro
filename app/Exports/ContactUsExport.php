<?php

namespace App\Exports;

use App\Models\ContactUs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

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

        return [
            $no,
            $row->NamaLengkap,
            $row->Email,
            $row->NomorHandphone ?? '-',
            $row->CompanyName ?? '-',
            $row->LokasiPerusahaan ?? '-',
            $row->ProdukYangDibutuhkan ?? '-',
            $row->Pesan ?? '-',
            $row->created_at ? $row->created_at->format('d-m-Y H:i') : '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '007BFF']
            ],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center']
        ]);

        // Auto-size columns
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Wrap text for message column (H)
        $sheet->getStyle('H:H')->getAlignment()->setWrapText(true);

        // Borders
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A1:I{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ]
        ]);

        return [];
    }
}
