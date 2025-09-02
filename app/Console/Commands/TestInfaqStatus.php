<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Infaq\Infaq;

class TestInfaqStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:infaq-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test infaq status accessor';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $infaqs = Infaq::all();
        
        $this->info("Testing infaq status accessor:");
        
        foreach ($infaqs as $infaq) {
            $this->line("ID: {$infaq->id}");
            $this->line("Donor Email: {$infaq->donor_email}");
            $this->line("Donor Phone: {$infaq->donor_phone}");
            $this->line("Status: {$infaq->status}");
            $this->line("Status Label: {$infaq->status_label}");
            $this->line("Payment Method: {$infaq->payment_method}");
            $this->line("Payment Method Label: {$infaq->payment_method_label}");
            $this->line("---");
        }
        
        // Test user data
        $this->info("\nUser data:");
        $users = \App\Models\User::all(['id', 'name', 'email', 'phone']);
        foreach ($users as $user) {
            $this->line("ID: {$user->id}, Email: {$user->email}, Phone: {$user->phone}");
        }
        
        // Test profile data matching
        $this->info("\nProfile data matching test:");
        $testUser = \App\Models\User::where('email', 'testprofile@example.com')->first();
        if ($testUser) {
            $this->line("Test user found - Email: {$testUser->email}, Phone: {$testUser->phone}");
            
            $userInfaqs = Infaq::where('donor_email', $testUser->email)
                ->orWhere('donor_phone', $testUser->phone)
                ->get();
                
            $this->line("Infaqs found for test user: {$userInfaqs->count()}");
            foreach ($userInfaqs as $infaq) {
                $this->line("  - Infaq ID: {$infaq->id}, Status: {$infaq->status_label}");
            }
            
            // Test exact controller logic
            $this->info("\nTesting controller logic:");
            $orders = $testUser->orders()
                ->with(['orderItems.product'])
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'orders_page');
            
            $infaqs = Infaq::where('donor_email', $testUser->email)
                ->orWhere('donor_phone', $testUser->phone)
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'infaq_page');
                
            $this->line("Orders paginated count: {$orders->count()}");
            $this->line("Infaqs paginated count: {$infaqs->count()}");
            
            $this->info("Infaq details in paginated result:");
            foreach ($infaqs as $infaq) {
                $this->line("  - ID: {$infaq->id}, Status: '{$infaq->status}', Label: '{$infaq->status_label}'");
            }
        } else {
            $this->line("Test user not found");
        }
        
        return 0;
    }
}
