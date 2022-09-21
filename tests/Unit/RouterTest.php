<?php

namespace Test\Unit;

use App\Exceptions\RouteNotFoundException;
use App\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        // given that we have a router object
        $this->router = new Router();
    }

    /** @test */
    public function test_it_registers_a_route() {
      // given that we have a router object
      //  $this->router = new Router();
           //when we call a register methon
        $this->router->register('get','/users',["Users",'index']);
        //then we assert  route was registered
        $expected = [
            'get' => [
                '/users' => ['Users','index']
            ]
        ];

        $this->assertEquals($expected,$this->router->routes());
    }
    /** @test */
    public function it_registers_a_get_route() {

        //when we call a register methon
        $this->router->get('/users',["Users",'index']);
        //then we assert  route was registered
        $expected = [
            'get' => [
                '/users' => ['Users','index']
            ]
        ];

        $this->assertEquals($expected,$this->router->routes());
    }
    /** @test */
    public function it_registers_a_post_route() {
        //when we call a register methon
        $this->router->post('/users',["Users",'store']);
        //then we assert  route was registered
        $expected = [
            'post' => [
                '/users' => ['Users','store']
            ]
        ];

        $this->assertEquals($expected,$this->router->routes());
    }
    /** @test */
    public function there_are_no_routes_when_router_is_created() {

        $router = new Router();
        $this->assertEmpty($this->router->routes());

    }
    /**
     * @test
     * @dataProvider routeNotFoundCases
     */

    public function it_throws_route_not_found_exception(
        $requestUri,
        $requestMethod
    ) {
        $users = new class() {
            public function someMethod(){
                return true;
            }

        };
        //store methodn doesnt exist
        $this->router->post('/users',[$users::class,'store']);
        $this->router->get('/users',["Users",'index']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($requestUri,$requestMethod);
    }
    public function routeNotFoundCases() {
        return [
            [
                '/users','put'
            ],
            [
                '/invoices','post'
            ],
            // class doesnt exist
            [
                '/users','get'
            ],
            [
                '/users','post'
            ],

        ];
    }
}