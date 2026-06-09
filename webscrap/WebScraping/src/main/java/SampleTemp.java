import org.openqa.selenium.By;
import org.openqa.selenium.NoSuchElementException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;

public class SampleTemp {

    public static void main(String[] args) {

        WebDriver driver = new ChromeDriver();
        driver.get("https://www.amazon.in/Society-Tea-Regular-Pouch-1kg/dp/B00WMNXP82");
//        driver.get("https://www.bigbasket.com/pd/40120006");
//        String price = driver.findElement(By.xpath("//span[@class='a-price aok-align-center reinventPricePriceToPayMargin priceToPay']//span[@class='a-offscreen']")).getText();


        try {
            String wholePrice = driver.findElement(By.xpath("//span[@class='a-price aok-align-center reinventPricePriceToPayMargin priceToPay']/span/span[@class='a-price-whole']")).getText();
            String fractionPrice = driver.findElement(By.xpath("//span[@class='a-price aok-align-center reinventPricePriceToPayMargin priceToPay']/span/span[@class='a-price-fraction']")).getText();
            String price = wholePrice + "." + fractionPrice;
            System.out.println(price);
        } catch (NoSuchElementException ex) {
            String price = driver.findElement(By.xpath("//span[@class='a-price a-text-price a-size-medium apexPriceToPay']")).getText();
            System.out.println(price.split("₹")[1]);
        }


//        System.out.println(price.split("₹")[1]);
        driver.quit();
    }

}
