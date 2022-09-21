<?php

namespace Tests\Unit\Services;

use App\Services\EmailService;
use App\Services\InvoiceService;
use App\Services\PaymentGatewayService;
use App\Services\SalesTaxService;
use PHPUnit\Framework\TestCase;

class InvocieServiceTest extends TestCase
{
    /** @test */
    public function it_processes_invoice(): void{
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $gatewayServiceMock = $this->createMock(PaymentGatewayService::class);
        $emailTaxServiceMock = $this->createMock(EmailService::class);

        $gatewayServiceMock->method('charge')->willReturn(True);
        //given invoice service
        $invoiceService = new InvoiceService($salesTaxServiceMock,$gatewayServiceMock,
            $emailTaxServiceMock
        );
        //when process method is called
        $customer = ['name' => 'ilya'];
        $amount = 200;
        $result = $invoiceService->process($customer,$amount);
        //then assert invoce is processed successfully
        $this->assertTrue($result);


    }
    /** @test */
    public function it_sends_receipt_email_when_invoice_is_processed(): void
    {
        $customer = ['name' => 'ilya'];
        $ExpectedCustomer = ['name' => 'il'];

        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $gatewayServiceMock  = $this->createMock(PaymentGatewayService::class);
        $emailServiceMock    = $this->createMock(EmailService::class);

        $gatewayServiceMock->method('charge')->willReturn(true);

        $emailServiceMock
            ->expects($this->once())
            ->method('send')
            ->with($ExpectedCustomer, 'receipt');

        // given invoice service
        $invoiceService = new InvoiceService(
            $salesTaxServiceMock,
            $gatewayServiceMock,
            $emailServiceMock
        );

        $amount   = 150;

        // when process is called
        $result = $invoiceService->process($customer, $amount);

        // then assert invoice is processed successfully
        $this->assertTrue($result);
    }

}