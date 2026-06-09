import org.openqa.selenium.By;
import org.openqa.selenium.NoSuchElementException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.time.Duration;

public class CapturePrices {

    public static void main(String[] args) throws SQLException {

        Object latestData[][] = updateData();

        for (int i = 0; i < latestData.length; i++) {
            // Loop through each column
            for (int j = 0; j < latestData[i].length; j++) {
                System.out.print(latestData[i][j] + " | ");
            }
            // Print new line after each row
            System.out.println();
        }

        String url = "jdbc:mysql://127.0.0.1:3306/myshop";
        String username = "root";
        String password = "";

        Connection conn = null;
        Statement stmt = null;

        try {
            conn = DriverManager.getConnection(url, username, password);

            stmt = conn.createStatement();

            for (int i = 1; i < latestData.length; i++) {
                // Loop through each column
                String price = null;
                String product = null;
                String shop = null;

                for (int j = 0; j < latestData[i].length; j++) {
                    if (j == 1)
                        product = latestData[i][1].toString();
                    if (j == 2)
                        shop = latestData[i][2].toString();
                    if (j == 4)
//                        price = Float.parseFloat((String) latestData[i][4]);
                        price = latestData[i][4].toString();
                }

                System.out.println("updating DB price.... " + price);

                if (product.contains("'"))
                    product = product.replace("'","''");

                String sqlQuery = "Update products Set Price = " + price + " where Product = '" + product + "' and Shop = '" + shop + "'";
                int rowsAffected = stmt.executeUpdate(sqlQuery);
                System.out.println("Rows Affected = " + rowsAffected);

                // Print new line after each row
                System.out.println();
            }

        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            if (stmt != null)
                stmt.close();
            if (conn != null)
                conn.close();
        }

    }

    public static Object[][] updateData() {
        ChromeOptions opt = new ChromeOptions();
//        opt.addArguments("--headless=new");

        Object[][] data = GetData.getData();

        WebDriver driver = new ChromeDriver(opt);
//        driver.manage().window().maximize();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(10));

        for (int i = 1; i < data.length; i++) {
            String link = null;
            String shop = null;
            String availability = null;
            float price = 0;
            for (int j = 0; j < data[i].length; j++) {

                if (j == 2) shop = data[i][2].toString();

                if (j == 3) {
                    link = data[i][3].toString();
                    if (shop.equalsIgnoreCase("Dmart")) {
                        driver.get(link);
                        String price1 = null;
                        try {
//                            price1 = driver.findElement(By.xpath("//span[@class='price-details-component_sp___qeys']/span")).getText();
                            price1 = driver.findElement(By.xpath("(//span[@class='price-details-component_value__IvVER'])[2]")).getText();
                        } catch (Exception e) {
                            driver.navigate().refresh();
                            price1 = driver.findElement(By.xpath("(//span[@class='price-details-component_value__IvVER'])[2]")).getText();
                        }
                        price = Float.parseFloat(price1.split(" ")[1]);
                    } else if (shop.equalsIgnoreCase("bigbasket")) {
                        driver.get(link);
                        String price1 = null;
                        try {
                            price1 = driver.findElement(By.xpath("//td[@class='Description___StyledTd-sc-82a36a-4 fLZywG']")).getText();
                        } catch (Exception e) {
                            price1 = driver.findElement(By.xpath("//td[@class='Description___StyledTd-sc-82a36a-4 fLZywG']")).getText();
                        }
                        price = Float.parseFloat(price1.split("₹")[1]);
                    } else if (shop.equalsIgnoreCase("Amazon")) {
                        driver.get(link);
                        String price1 = null;
                        try {
                            String wholePrice = driver.findElement(By.xpath("//span[@class='a-price aok-align-center reinventPricePriceToPayMargin priceToPay']/span/span[@class='a-price-whole']")).getText();
                            String fractionPrice = driver.findElement(By.xpath("//span[@class='a-price aok-align-center reinventPricePriceToPayMargin priceToPay']/span/span[@class='a-price-fraction']")).getText();
                            price1 = wholePrice + "." + fractionPrice;
//                            System.out.println("price1 = " + price1);
                            if (price1 == null) {
                                price1 = driver.findElement(By.xpath("(//span[@class='a-size-medium a-color-price'])[1]")).getText();
                            }
                        } catch (NoSuchElementException ex) {
                            try {
                                driver.navigate().refresh();
                                String message = driver.findElement(By.xpath("//span[@class='a-size-medium a-color-success']")).getText();
                                if (message.contains("Currently unavailable.")) price1 = "0";
                            } catch (NoSuchElementException ex1) {
                                price1 = driver.findElement(By.xpath("//span[@class='a-price a-text-price a-size-medium apexPriceToPay']")).getText();
                                price1 = price1.split("₹")[1];
                            }

                        } catch (Exception e) {
                            String wholePrice = driver.findElement(By.xpath("//span[@class='a-price aok-align-center reinventPricePriceToPayMargin priceToPay']/span/span[@class='a-price-whole']")).getText();
                            String fractionPrice = driver.findElement(By.xpath("//span[@class='a-price aok-align-center reinventPricePriceToPayMargin priceToPay']/span/span[@class='a-price-fraction']")).getText();
                            price1 = wholePrice + "." + fractionPrice;
                            if (price1 == null) {
                                price1 = driver.findElement(By.xpath("//*[@id='corePriceDisplay_desktop_feature_div']/div[1]/span[2]/span/span[1]")).getText();
                            }
                        }
//                        System.out.println("price1 ===== " + price1);
                        if (price1 == null) {
                            try {
                                price1 = driver.findElement(By.xpath("//*[@id='corePriceDisplay_desktop_feature_div']/div[1]/span[3]/span[2]/span[2]")).getText();
//                                System.out.println("| New xpath price = " + price1 + " |");
                            } catch (Exception e) {
                                try {
                                    price1 = driver.findElement(By.xpath("//*[@id='corePriceDisplay_desktop_feature_div']/div[1]/span[2]/span[2]/span[2]")).getText();
//                                    System.out.println("| New xpath price 1 = " + price1 + " |");
                                } catch (Exception ex) {
                                    price1 = driver.findElement(By.xpath("//*[@id='corePrice_desktop']/div/table/tbody/tr[2]/td[2]/span[1]/span[2]")).getText();
//                                    System.out.println("| New xpath price 2 = " + price1 + " |");
                                    price1 = price1.split("₹")[1];
                                }

                            }
                        }

                        try {
//                            System.out.print("| Parsing = " + price1 + " |");
                            price = Float.parseFloat(price1);
                        } catch (Exception ex) {
                            price = Integer.parseInt(price1);
                        }
                    }
                }

                if (j == 4) data[i][4] = price;

                if (j == 5) {
                    if (shop.equalsIgnoreCase("Amazon")) {
                        if (price != 0)
                            data[i][5] = "AVAILABLE";
                        else
                            data[i][5] = "NOT AVAILABLE";
                    } else if (shop.equalsIgnoreCase("Dmart")) {
                        boolean isEnabled = driver.findElement(By.xpath("//div[@class='addToCart_component_action-container__WnZyd']/button")).isEnabled();
                        if (isEnabled == true)
                            data[i][5] = "AVAILABLE";
                        else
                            data[i][5] = "NOT AVAILABLE";
                    } else {
                        String status = null;
                        try {
                            status = driver.findElement(By.xpath("//button[@class='Button-sc-1dr2sn8-0 CTA___StyledButton-sc-yj3ixq-5 kYQsWi bYACar']")).getText();
                        } catch (Exception e) {
                            status = driver.findElement(By.xpath("//button[@class='Button-sc-1dr2sn8-0 CtaButtons___StyledButton3-sc-1tlmn1r-2 kYQsWi iixlzA']")).getText();
                        }

                        if (status.equalsIgnoreCase("Add to basket"))
                            data[i][5] = "AVAILABLE";
                        else if (status.equalsIgnoreCase("Notify Me"))
                            data[i][5] = "NOT AVAILABLE";
                        else
                            data[i][5] = "NOT AVAILABLE";
                    }
                }

                System.out.print(data[i][j] + "\t");


            }
            System.out.println();
        }

        driver.quit();

        return data;
    }

}
