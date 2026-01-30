<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportsController extends Controller
{
    public function aging(Request $request): View
    {
        $today = now()->startOfDay();

        $agingBuckets = Invoice::select([
            DB::raw('SUM(CASE WHEN due_at >= ? THEN amount_due ELSE 0 END) as current'),
            DB::raw('SUM(CASE WHEN due_at < ? AND due_at >= ? THEN amount_due ELSE 0 END) as days_1_30'),
            DB::raw('SUM(CASE WHEN due_at < ? AND due_at >= ? THEN amount_due ELSE 0 END) as days_31_60'),
            DB::raw('SUM(CASE WHEN due_at < ? AND due_at >= ? THEN amount_due ELSE 0 END) as days_61_90'),
            DB::raw('SUM(CASE WHEN due_at < ? THEN amount_due ELSE 0 END) as days_90_plus'),
        ])
            ->setBindings([
                $today,
                $today,
                $today->copy()->subDays(30),
                $today->copy()->subDays(30),
                $today->copy()->subDays(60),
                $today->copy()->subDays(60),
                $today->copy()->subDays(90),
                $today->copy()->subDays(90),
            ])
            ->where('status', '!=', 'paid')
            ->first();

        return view('reports.aging', [
            'aging' => $agingBuckets,
        ]);
    }

    public function salesByCustomer(): View
    {
        $sales = Invoice::query()
            ->select('customers.name as customer_name', DB::raw('SUM(invoices.total) as total_sales'))
            ->join('customers', 'customers.id', '=', 'invoices.customer_id')
            ->where('invoices.status', 'paid')
            ->groupBy('customers.name')
            ->orderByDesc('total_sales')
            ->get();

        return view('reports.sales-by-customer', [
            'sales' => $sales,
        ]);
    }
}
