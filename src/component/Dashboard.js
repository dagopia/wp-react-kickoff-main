import React, { useState, useEffect } from "react";
import { CartesianGrid, Line, LineChart, XAxis, YAxis } from "recharts";

const Dashboard = () => {
    const [data, setData] = useState([]);
    const [selectedTimeRange, setSelectedTimeRange] = useState("7"); // Default to "Last 7 days"

    useEffect(() => {
        const fetchData = async () => {
            try {
                const startDate = getStartDate(selectedTimeRange);
                const endDate = getCurrentDate();

                // Define API endpoint and mapping function
                const endpoint = "pages"; // You can change this to "posts" or any other custom endpoint
                const mappingFunction = (post) => ({
                    name: post.title.rendered,
                    uv: post.views || 0,
                    pv: post.likes || 0,
                });

                // Fetch data from WordPress REST API based on selected time range and dynamic endpoint
                const apiUrl = `http://localhost:10022/wp-json/wp/v2/${endpoint}?after=${startDate}&before=${endDate}`;

                const response = await fetch(apiUrl);

                if (!response.ok) {
                    throw new Error("Failed to fetch data");
                }

                const posts = await response.json();

                // Map fetched data using the dynamic mapping function
                const chartData = posts.map(mappingFunction);

                setData(chartData);
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        };

        fetchData();
    }, [selectedTimeRange, setSelectedTimeRange]);

    // Helper function to get the start date based on the selected time range
    const getStartDate = (days) => {
        const today = new Date();
        const startDate = new Date(today);
        startDate.setDate(today.getDate() - days);
        return startDate.toISOString();
    };

    // Helper function to get the current date
    const getCurrentDate = () => {
        return new Date().toISOString();
    };

    return (
        <div className="dashboard-chart-widget">
            <div className="dashboard-chart-widget-header">
                <label>Select Time Range</label>
                <select
                    value={selectedTimeRange}
                    onChange={(e) => {
                        setSelectedTimeRange(e.target.value);
                    }}
                >
                    <option value={7}>Last 7 days</option>
                    <option value={15}>Last 15 days</option>
                    <option value={500}>Last 1 month</option>
                </select>
            </div>
            <div className="dashboard-chart-widget-chart">
                <div className="chart-label">Chart</div>
                <div className="chart">
                    {/* Make chart properties dynamic */}
                    <LineChart width={300} height={300} data={data}>
                        <XAxis dataKey="name" />
                        <YAxis />
                        <CartesianGrid stroke="#eee" strokeDasharray="5 5" />
                        <Line type="monotone" dataKey="uv" stroke="#8884d8" />
                        <Line type="monotone" dataKey="pv" stroke="#82ca9d" />
                    </LineChart>
                </div>
            </div>
        </div>
    );
};

export { Dashboard };
