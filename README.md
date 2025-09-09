# carrefour-dev
Link de pagamento para Android
SDK do Link de Pagamento para Android com PHP

## Tecnologias utilizadas 

Bootstrap core, html, CSS, javascript e PHP
Yarn
Postman

## Principais recursos

* [x] Autenticação no oAuth
* [x] Crianção do link de pagamento
  * [x] De todos os tipos de produtos
  * [x] Com todos os tipos de entrega
  * [x] Com recorrência
        
Instalação
É necessária a permissão de uso da internet no Android Manifest.xml:

    <uses-permission android:name="android.permission.INTERNET"/>
E para utilizar o SDK é necessário também implementar no build.gradle(app:):

dependencies {
    ...
    implementation 'br.com.braspag:cielo-payment-link:1.0.2'
}
Uso
Para utilizar o SDK é necessário instanciar CieloPaymentsLinkClient e CieloPaymentsLinkParameters , chamar a função generateLink , passando os parâmetros e implementando CieloPaymentsLinkCallbacks , conforme o exemplo abaixo:

class MainActivity : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        val paymentsLink = CieloPaymentsLinkClient(
            environment= Environment.SANDBOX,
            clientId = "YOUR-CLIENT-ID",
            clientSecret = "YOUR-CLIENT-SECRET"
        )
        val parameters = CieloPaymentsLinkParameters(
            "order_name", "400000", SaleType.DIGITAL, ShippingType.CORREIOS,
            "test_deliver", "10000", recurrentInterval = RecurrentInterval.MONTHLY
        )

        paymentsLink.generateLink(parameters, object :
            CieloPaymentsLinkCallbacks {
            override fun onGetLink(response: Transaction) {
                txt1.text = response.shortUrl
            }

            override fun onError(error: String) {
                txt1.text = "error generating link, $error"
            }
        })
    }
}
